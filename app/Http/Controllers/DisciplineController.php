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

class DisciplineController extends Controller
{
    public function getDisciplines() {
        if (Gate::allows('admin')) {
            return view('admin.manage-disciplines', ['disciplines' => Discipline::all()]);
        }
        elseif (Gate::allows('teacher')){
            return view('user.disciplines', ['disciplines' => Discipline::all()]);
        }
        else{
            return view('user.disciplines', ['disciplines' => Discipline::all()]);
        }
    }

    public function subscribe(Request $request){
        $discipline = Discipline::where('id', '=', $request->id)->first();
        $user = Auth::user();
        if($user->disciplines->contains($discipline)){
            return abort(403);
        }
        $user->disciplines()->attach($discipline, ['id' => uniqid()]);
        $NOT_AVAILABLE = TestStatus::where('name', '=', 'not available')->first();
        $AVAILABLE = TestStatus::where('name', '=', 'available')->first();
        foreach ($discipline->tests()->orderBy('order_number')->get() as $i => $test){
            $userTest = new UserTest();
            $userTest->id = uniqid();
            $userTest->user = $user->id;
            $userTest->test = $test->id;
            $userTest->status = !$i ? $AVAILABLE->id : $NOT_AVAILABLE->id;
            $userTest->save();
        }
        return redirect(route('getDisciplines'));
    }



    // CRUD API

    public function addDiscipline(Request $request){
        if(!$request->newName){
            return view('admin.manage-disciplines', ['disciplines' => Discipline::all(), 'message' => 'Поле название обязательно', 'messageType' => 'danger']);
        }
        $discipline = new Discipline();
        $discipline->id = uniqid();
        $discipline->name = $request->newName;
        $discipline->img = $request->newImage ?? null;
        $discipline->save();
        return view('admin.manage-disciplines', ['disciplines' => Discipline::all(), 'message' => 'Дисциплина успешно добавлена!', 'messageType' => 'success']);
    }

    public function editDiscipline(Request $request){
        $discipline = Discipline::where('id', '=', $request->id)->first();
        $discipline->name = $request->newName ?? $discipline->name;
        $discipline->img = $request->newImage ?? $discipline->img;
        $discipline->save();

        return view('admin.manage-disciplines', ['disciplines' => Discipline::all(), 'message' => 'Дисциплина успешно обновлена!', 'messageType' => 'success']);
    }

    public function deleteDiscipline(Request $request){
        $discipline = Discipline::where('id', '=', $request->id)->first();
        $tests = Test::where('discipline', '=', $discipline->id)->get();
        DB::table('user_discipline')->where('discipline', $discipline->id)->delete();
        foreach ($tests as $test){
            $user_tests = UserTest::where('test', '=', $test->id)->get();
            $questions = Question::where('test', '=', $test->id)->get();
            foreach ($user_tests as $user_test){
                $user_test->delete();
            }
            foreach ($questions as $question){
                $answers = Answer::where('question', '=', $question->id);
                foreach ($answers as $answer){
                    $answer->delete();
                }
                $question->delete();
            }
        }
        $discipline->delete();
        return view('admin.manage-disciplines', ['disciplines' => Discipline::all(), 'message' => 'Дисциплина успешно удалена!', 'messageType' => 'success']);
    }
}
