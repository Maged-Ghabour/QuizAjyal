<?php

namespace Database\Seeders;

use App\Models\Question;
use App\Models\QuestionMatchPair;
use App\Models\QuestionOption;
use App\Models\Quiz;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class QuizSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Create admin user
        $admin = User::firstOrCreate(
            ['email' => 'admin@quizez.com'],
            [
                'name' => 'Admin',
                'password' => Hash::make('password'),
            ]
        );

        // Create sample quiz: English Alphabet
        $quiz = Quiz::create([
            'user_id' => $admin->id,
            'title' => 'English Alphabet Quiz',
            'description' => 'Test your knowledge of the English alphabet with fun questions including matching, fill-in-the-blank, and multiple choice!',
            'duration_minutes' => 15,
            'is_active' => true,
            'show_results' => true,
            'randomize_questions' => false,
            'pass_percentage' => 60,
        ]);

        // Q1: MCQ
        $q1 = Question::create([
            'quiz_id' => $quiz->id,
            'type' => 'mcq',
            'question_text' => 'Which letter comes after "C" in the alphabet?',
            'points' => 2,
            'sort_order' => 1,
        ]);
        foreach ([
            ['option_text' => 'A', 'label' => 'A', 'is_correct' => false],
            ['option_text' => 'B', 'label' => 'B', 'is_correct' => false],
            ['option_text' => 'D', 'label' => 'C', 'is_correct' => true],
            ['option_text' => 'E', 'label' => 'D', 'is_correct' => false],
        ] as $i => $opt) {
            QuestionOption::create(array_merge($opt, [
                'question_id' => $q1->id,
                'sort_order' => $i,
            ]));
        }

        // Q2: Fill in the blank
        Question::create([
            'quiz_id' => $quiz->id,
            'type' => 'fill_blank',
            'question_text' => 'Complete the word: _PPLE (the missing first letter)',
            'correct_answer' => 'A',
            'points' => 2,
            'sort_order' => 2,
        ]);

        // Q3: True/False
        $q3 = Question::create([
            'quiz_id' => $quiz->id,
            'type' => 'true_false',
            'question_text' => 'The letter "Z" is the last letter of the English alphabet.',
            'correct_answer' => 'true',
            'points' => 1,
            'sort_order' => 3,
        ]);

        // Q4: Match
        $q4 = Question::create([
            'quiz_id' => $quiz->id,
            'type' => 'match',
            'question_text' => 'Match each letter with the word that starts with it:',
            'points' => 4,
            'sort_order' => 4,
        ]);
        foreach ([
            ['left_text' => 'A', 'right_text' => 'Apple'],
            ['left_text' => 'B', 'right_text' => 'Ball'],
            ['left_text' => 'C', 'right_text' => 'Cat'],
            ['left_text' => 'D', 'right_text' => 'Dog'],
        ] as $i => $pair) {
            QuestionMatchPair::create(array_merge($pair, [
                'question_id' => $q4->id,
                'sort_order' => $i,
            ]));
        }

        // Q5: MCQ (another one)
        $q5 = Question::create([
            'quiz_id' => $quiz->id,
            'type' => 'mcq',
            'question_text' => 'How many letters are in the English alphabet?',
            'points' => 2,
            'sort_order' => 5,
        ]);
        foreach ([
            ['option_text' => '24', 'label' => 'A', 'is_correct' => false],
            ['option_text' => '25', 'label' => 'B', 'is_correct' => false],
            ['option_text' => '26', 'label' => 'C', 'is_correct' => true],
            ['option_text' => '27', 'label' => 'D', 'is_correct' => false],
        ] as $i => $opt) {
            QuestionOption::create(array_merge($opt, [
                'question_id' => $q5->id,
                'sort_order' => $i,
            ]));
        }

        // Q6: Fill in the blank
        Question::create([
            'quiz_id' => $quiz->id,
            'type' => 'fill_blank',
            'question_text' => 'Complete the word: SU_ (what letter is missing at the end?) — Think of the bright thing in the sky!',
            'correct_answer' => 'N',
            'points' => 2,
            'sort_order' => 6,
        ]);

        // Q7: True/False
        Question::create([
            'quiz_id' => $quiz->id,
            'type' => 'true_false',
            'question_text' => 'The letter "B" comes before "A" in the alphabet.',
            'correct_answer' => 'false',
            'points' => 1,
            'sort_order' => 7,
        ]);

        // === Second Quiz: Math Basics ===
        $quiz2 = Quiz::create([
            'user_id' => $admin->id,
            'title' => 'Math Basics Quiz',
            'description' => 'A fun quiz to test basic math skills with various question types.',
            'duration_minutes' => 20,
            'is_active' => true,
            'show_results' => true,
            'randomize_questions' => true,
            'pass_percentage' => 50,
        ]);

        $mq1 = Question::create([
            'quiz_id' => $quiz2->id,
            'type' => 'mcq',
            'question_text' => 'What is 5 + 3?',
            'points' => 2,
            'sort_order' => 1,
        ]);
        foreach ([
            ['option_text' => '6', 'label' => 'A', 'is_correct' => false],
            ['option_text' => '7', 'label' => 'B', 'is_correct' => false],
            ['option_text' => '8', 'label' => 'C', 'is_correct' => true],
            ['option_text' => '9', 'label' => 'D', 'is_correct' => false],
        ] as $i => $opt) {
            QuestionOption::create(array_merge($opt, [
                'question_id' => $mq1->id,
                'sort_order' => $i,
            ]));
        }

        Question::create([
            'quiz_id' => $quiz2->id,
            'type' => 'fill_blank',
            'question_text' => 'What is 10 - 4 = ? (write just the number)',
            'correct_answer' => '6',
            'points' => 2,
            'sort_order' => 2,
        ]);

        Question::create([
            'quiz_id' => $quiz2->id,
            'type' => 'true_false',
            'question_text' => '2 × 3 = 6',
            'correct_answer' => 'true',
            'points' => 1,
            'sort_order' => 3,
        ]);
    }
}
