<?php

namespace App\Http\Controllers;

use App\Models\Answer;
use App\Models\Discipline;
use App\Models\Question;
use App\Models\Test;
use App\Models\TestStatus;
use App\Models\UserTest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Gate;

class TestController extends Controller
{
    public function getTests(Request $request)
    {
        $user = Auth::user();
        $data = $request->data;
        if (!$request->query('discipline')) {
            return abort(404);
        }
        $discipline = $request->query('discipline');
        if (Gate::allows('admin')) {
            return view('admin.manage-tests', ['tests' => Test::where('discipline', '=', $discipline)->orderBy('order_number')->get(), 'discipline' => Discipline::where('id', '=', $discipline)->first(), 'message' => $data['message'] ?? null, 'messageType' => $data['messageType'] ?? null]);
        } elseif (Gate::allows('teacher')) {
            return view('admin.manage-tests', ['tests' => Test::where('discipline', '=', $discipline)->orderBy('order_number')->get(), 'discipline' => Discipline::where('id', '=', $discipline)->first(), 'message' => $data['message'] ?? null, 'messageType' => $data['messageType'] ?? null]);
        } else {
            $data = Test::where('discipline', '=', $discipline)->join('user_test', 'user_test.test', '=', 'tests.id')->join('test_statuses', 'user_test.status', '=', 'test_statuses.id')->where('user_test.user', $user->id)->select('tests.*', 'test_statuses.name as status')->orderBy('tests.order_number')->get();
            return view('user.tests', ['tests' => $data, 'discipline' => Discipline::where('id', '=', $discipline)->first(), 'message' => $data['message'] ?? null, 'messageType' => $data['messageType'] ?? null]);
        }
    }

    public function editTest(Request $request)
    {
        if (!$request->query('discipline')) {
            return abort(404);
        }
        $discipline = $request->query('discipline');
        $test = Test::where('id', '=', $request->test_id)->first();
        $test->name = $request->name ?? $test->name;
        $test->time = $request->time ?? $test->time;
        $test->pass_score = $request->score ?? $test->pass_score;
        $test->order_number = $request->order ?? $test->order_number;
        $test->save();
        return redirect(route('getTests', ['data' => ['message' => 'Тест успешно изменён', 'messageType' => 'success'], 'discipline' => $discipline]));
    }

    public function deleteTest(Request $request){
        if (!$request->query('discipline')) {
            return abort(404);
        }
        $discipline = $request->query('discipline');
        $test = Test::where('id', '=', $request->id)->first();
        $questions = Question::where('test', '=', $test->id)->get();
        foreach ($questions as $question){
            $answers = Answer::where('question', '=', $question->id);
            foreach ($answers as $answer) {
                $answer->delete();
            }
            $question->delete();
        }
        $user_tests = UserTest::where('test', '=', $test->id)->get();
        foreach ($user_tests as $user_test){
            $user_test->delete();
        }
        $test->delete();
        return redirect(route('getTests', ['data' => ['message' => 'Тест успешно удалён', 'messageType' => 'success'], 'discipline' => $discipline]));
    }

    public function addTest(Request $request)
    {
        if (!$request->query('discipline')) {
            return abort(404);
        }
        $discipline = $request->query('discipline');
        if(!$request->name || !$request->time || !$request->score){
            return redirect(route('getTests', ['data' => ['message' => 'Не введено обязательное поле', 'messageType' => 'danger'], 'discipline' => $discipline]));
        }
        $test = new Test();
        $test->id = uniqid();
        $test->name = $request->name;
        $test->discipline = $discipline;
        $test->time = $request->time;
        $test->pass_score = $request->score;
        $test->order_number = $request->order ?? Discipline::where('id', '=', $discipline)->get()->count() + 1;
        $test->save();
        return redirect(route('getTests', ['data' => ['message' => 'Тест успешно добавлен', 'messageType' => 'success'], 'discipline' => $discipline]));
    }

    public function startTest(Request $request, $id){
        $test = Test::where('id', '=', $id)->first();
        $user = Auth::user();
        $user_test = UserTest::where('test', '=', $id)->where('user', '=', $user->id)->first();
        $status = TestStatus::where('id', '=', $user_test->status)->first();
        //strtotime($user_test->endtime) < time()
        switch ($status->name){
            case 'not available':
                return abort(419);
            case 'available':
                $questions = Question::where('test', '=', $test->id)->get();
                $user_test->endtime = time() + $test->time*60;
                $newStatus = TestStatus::where('name', '=', 'in progress')->first();
                $user_test->status = $newStatus->id;
                foreach ($questions as $question){
                    $user->questions()->attach($question, ['id' => uniqid(), 'score' => 0]);
                }
                $user_test->save();
                return redirect(route('renderQuestion', [$id, 1]));
            case 'in progress':
                return redirect(route('renderQuestion', [$id, 1]));
            case 'failed':
                $user_test->endtime = time() + $test->time*60;
                $newStatus = TestStatus::where('name', '=', 'in progress')->first();
                $user_test->status = $newStatus->id;
                $user_test->save();
                return redirect(route('renderQuestion', [$id, 1]));
        }
    }

    public function testResult(Request $request, $id){
        $test = Test::where('id', $id)->first();
        $user = Auth::user();
        $user_test = UserTest::where('user', $user->id)->where('test', $id)->first();
        $available = TestStatus::where('name', 'available')->first();
        $completed = TestStatus::where('name', 'completed')->first();
        $failed = TestStatus::where('name', 'failed')->first();
        $user_questions = $user->questions()->where('test', $id)->get();
        $score = 0;
        foreach ($user_questions as $user_question){
            $score += $user_question->pivot->score;
        }
        $total = 0;
        foreach ($test->questions as $question){
            $total += $question->score;
        }
        $result = $score >= $test->pass_score;
        if($result){
            $user_test->status = $completed->id;
            $user_test->save();
            $discipline = Discipline::where('id', $test->discipline)->first();
            $check = false;
            foreach ($discipline->tests()->orderBy('order_number')->get() as $dis_test){
                if($check){
                    $newUserTest = UserTest::where('test', $dis_test->id)->where('user', $user->id)->first();
                    $newUserTest->status = $available->id;
                    $newUserTest->save();
                }
                if($dis_test->id == $id){
                    $check = true;
                }
            }
        }
        else{
            $user_test->status = $failed->id;
            $user_test->save();
        }
        return view('user.test-result', ['id' => $id, 'test' => $test, 'score' => $score, 'total' => $total, 'result' => $result, 'discipline' => $test->discipline]);
    }

    public function myTests(){
        $user = Auth::user();
        $data = DB::table('tests')->join('user_test', 'user_test.test', 'tests.id')->join('test_statuses', 'test_statuses.id', 'user_test.status')->join('disciplines', 'disciplines.id', 'tests.discipline')->where('user_test.user', $user->id)->where('test_statuses.name', 'completed')->select('tests.*', 'test_statuses.name as status', 'disciplines.name as discipline_name')->get();
        return view('user.my-tests', ['tests' => $data]);

    }

    public function addTestView(Request $request){
        return view('admin.add-test', ['discipline' => Discipline::where('id', '=', $request->query('discipline'))->first()]);
    }

    public function editTestView(Request $request){
        return view('admin.edit-test', ['discipline' => Discipline::where('id', '=', $request->query('discipline'))->first(), 'test_id' => $request->id]);
    }
}
