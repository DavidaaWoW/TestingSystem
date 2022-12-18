<?php

namespace App\Http\Controllers;

use App\Models\Answer;
use App\Models\Discipline;
use App\Models\Question;
use App\Models\QuestionVariation;
use App\Models\Test;
use App\Models\UserTest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Gate;

class QuestionController extends Controller
{
    public function getQuestions(Request $request)
    {
        $data = $request->data;
        if (!$request->query('test')) {
            return abort(404);
        }
        $test = $request->query('test');
        if (Gate::allows('admin')) {
            return view('admin.manage-questions', ['questions' => Question::where('test', '=', $test)->orderBy('order_number')->get(), 'test' => Test::where('id', '=', $test)->first(), 'message' => $data['message'] ?? null, 'messageType' => $data['messageType'] ?? null]);
        } elseif (Gate::allows('teacher')) {
            return view('admin.manage-questions', ['questions' => Question::where('test', '=', $test)->orderBy('order_number')->get(), 'test' => Test::where('id', '=', $test)->first(), 'message' => $data['message'] ?? null, 'messageType' => $data['messageType'] ?? null]);
        } else {
//            $data = Test::where('discipline', '=', $discipline)->join('user_test', 'user_test.test', '=', 'tests.id')->join('test_statuses', 'user_test.status', '=', 'test_statuses.id')->select('tests.*', 'test_statuses.name as status')->orderBy('tests.order_number')->get();
//            return view('user.tests', ['tests' => $data, 'discipline' => Discipline::where('id', '=', $discipline)->first(), 'message' => $data['message'] ?? null, 'messageType' => $data['messageType'] ?? null]);
        }
    }

    public function submitQuestion(Request $request){
        $user_answers = $request->answer;
        $user = Auth::user();
        $question = $user->questions()->where('questions.id', $request->question)->first();
        $test = Test::where('id', $question->test)->first();
        $user_test = UserTest::where('user', $user->id)->where('test', $test->id)->first();        strtotime($user_test->endtime) < time();
        if(strtotime($user_test->endtime) < time()){
            return redirect(route('testResult', $question->test));
        }
        $question_variation = QuestionVariation::where('id', $question->question_variation)->first();
        $answers = $question->answers()->where('correct', 1)->get();
        $all_answers = $question->answers()->where('correct', 0)->get();
        $question->pivot->score = 0;
        $question->pivot->save();
        if($question_variation->name == 'one correct'){
            foreach ($answers as $answer){
                if($answer->id == $user_answers[0]){
                    $question->pivot->score = $question->score;
                    $question->pivot->save();
                }
            }
        }
        elseif ($question_variation->name == 'multiple correct'){
            $point = $question->score / count($answers);
            $point_ = $question->score / count($all_answers);
            $score = 0;
            foreach ($user_answers as $user_answer){
                $check = false;
                foreach ($answers as $answer){
                    if($user_answer == $answer->id){
                        $check = true;
                    }
                }
                $check ? $score += $point : $score -= $point_;
            }
            $question->pivot->score = $score < 0 ? 0 : $score;
            $question->pivot->save();
        }
        if($request->order <= count($question->answers))
            return redirect(route('renderQuestion', [$question->test, $request->order + 1]));
        else{
            return redirect(route('testResult', $question->test));
        }
    }

    public function renderQuestion(Request $request, $id, $question)
    {
        $user = Auth::user();
        return view('user.question', ['test' => Test::where('id', '=', $id)->first(), 'question' => $user->questions()->join('question_variations', 'question_variations.id', '=', 'questions.question_variation')->select('questions.*', 'question_variations.name as question_variation')->where('questions.test', $id)->orderBy('questions.order_number')->skip($question - 1)->first(), 'order' => $question]);
    }

    public function addQuestionView(Request $request)
    {
        return view('admin.add-question', ['test' => Test::where('id', '=', $request->query('test'))->first()]);
    }


    public function addQuestion(Request $request)
    {
        if (!$request->query('test')) {
            return abort(404);
        }
        $test = $request->query('test');
        if (!$request->name || !$request->order || !$request->score) {
            return redirect(route('getQuestions', ['data' => ['message' => 'Не введено обязательное поле', 'messageType' => 'danger'], 'test' => $test]));
        }
        $question = new Question();
        $question->id = uniqid();
        $questionVariation = QuestionVariation::where('name', '=', $request->question_type)->first();
        $question->question_variation = $questionVariation->id;
        $question->name = $request->name;
        $question->test = $test;
        $question->score = $request->score;
        $question->order_number = $request->order;
        $question->save();
        foreach ($request->title as $key => $title) {
            $answer = new Answer();
            $answer->id = uniqid();
            $answer->name = $title;
            $answer->question = $question->id;
            foreach ($request->correct as $correct) {
                if ($correct == $key) {
                    $answer->correct = true;
                    break;
                }
                $answer->correct = false;
            }
            $answer->save();
        }
        return redirect(route('getQuestions', ['data' => ['message' => 'Вопрос успешно добавлен', 'messageType' => 'success'], 'test' => $test]));
    }

    public function deleteQuestion(Request $request)
    {
        if (!$request->query('test')) {
            return abort(404);
        }
        $test = $request->query('test');
        $question = Question::where('id', '=', $request->id)->first();
        $answers = Answer::where('question', '=', $question->id)->get();
        foreach ($answers as $answer) {
            $answer->delete();
        }
        $question->delete();
        return redirect(route('getQuestions', ['data' => ['message' => 'Тест успешно удалён', 'messageType' => 'success'], 'test' => $test]));
    }
}
