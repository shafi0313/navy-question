<?php

namespace Database\Seeders;

use App\Models\Question;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class QuestionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $questions = array(
            array('id' => '1','subject_id' => '1','type' => 'multiple_choice','ques' => 'বাংলা কাব্য রীতি কয় ভাগে বিভক্ত ?','mark' => '2','image' => NULL,'created_at' => '2024-08-09 10:58:44','updated_at' => '2024-08-09 10:58:44','deleted_at' => NULL),
            array('id' => '2','subject_id' => '1','type' => 'multiple_choice','ques' => 'ব্যঞ্জনবর্ণের বিকল্প রূপের নাম...','mark' => '2','image' => NULL,'created_at' => '2024-08-09 11:02:54','updated_at' => '2024-08-09 11:02:54','deleted_at' => NULL),
            array('id' => '3','subject_id' => '1','type' => 'multiple_choice','ques' => 'বচন ব্যাকরণের কোন অংশের আলোচ্য বিষয় ?','mark' => '2','image' => NULL,'created_at' => '2024-08-09 11:07:39','updated_at' => '2024-08-09 11:07:39','deleted_at' => NULL),
            array('id' => '4','subject_id' => '1','type' => 'multiple_choice','ques' => 'কোনটি তদ্ভব শব্দ ?','mark' => '2','image' => NULL,'created_at' => '2024-08-09 11:09:42','updated_at' => '2024-08-09 11:09:42','deleted_at' => NULL),
            array('id' => '5','subject_id' => '1','type' => 'multiple_choice','ques' => 'বিশেষ্যের পরিবর্তে ব্যবহৃত শব্দকে কি বলে?','mark' => '2','image' => NULL,'created_at' => '2024-08-09 11:12:12','updated_at' => '2024-08-09 11:12:12','deleted_at' => NULL),
            array('id' => '6','subject_id' => '1','type' => 'multiple_choice','ques' => 'বিশেষ্যের পরিবর্তে ব্যবহৃত শব্দকে কি বলে?','mark' => '2','image' => NULL,'created_at' => '2024-08-09 11:12:42','updated_at' => '2024-08-09 11:12:42','deleted_at' => NULL),
            array('id' => '7','subject_id' => '1','type' => 'multiple_choice','ques' => 'নিচের কোনটি একবচন ?','mark' => '2','image' => NULL,'created_at' => '2024-08-09 11:14:43','updated_at' => '2024-08-09 11:14:43','deleted_at' => NULL),
            array('id' => '8','subject_id' => '1','type' => 'multiple_choice','ques' => 'বাচ্য বলতে কী বোঝায় ?','mark' => '2','image' => NULL,'created_at' => '2024-08-09 11:18:09','updated_at' => '2024-08-09 11:18:09','deleted_at' => NULL),
            array('id' => '9','subject_id' => '1','type' => 'multiple_choice','ques' => '"কৈ মাছের প্রাণ " বাগধারাটির অর্থ কী ?','mark' => '2','image' => NULL,'created_at' => '2024-08-09 11:21:16','updated_at' => '2024-08-09 11:21:16','deleted_at' => NULL),
            array('id' => '10','subject_id' => '1','type' => 'multiple_choice','ques' => '\'বিবাহ\' শব্দের প্রতিশব্দ নয় কোনটি ?','mark' => '2','image' => NULL,'created_at' => '2024-08-09 11:23:58','updated_at' => '2024-08-09 11:23:58','deleted_at' => NULL),
            array('id' => '11','subject_id' => '1','type' => 'multiple_choice','ques' => 'কাজী নজরুল ইসলাম কীসের মধ্যে কোন ভেদা-ভেদ খুঁজে পান না ?','mark' => '2','image' => NULL,'created_at' => '2024-08-09 11:27:11','updated_at' => '2024-08-09 11:27:11','deleted_at' => NULL),
            array('id' => '12','subject_id' => '2','type' => 'multiple_choice','ques' => 'Which of the following has the same meaning as \'legendary\' ?','mark' => '2','image' => NULL,'created_at' => '2024-08-09 11:31:19','updated_at' => '2024-08-09 11:31:19','deleted_at' => NULL),
            array('id' => '13','subject_id' => '2','type' => 'multiple_choice','ques' => 'It is the strongest mode_______communications.','mark' => '2','image' => NULL,'created_at' => '2024-08-09 11:32:45','updated_at' => '2024-08-09 11:32:45','deleted_at' => NULL),
            array('id' => '14','subject_id' => '2','type' => 'multiple_choice','ques' => 'Man is ______no means free from death.','mark' => '2','image' => NULL,'created_at' => '2024-08-09 11:33:48','updated_at' => '2024-08-09 11:33:48','deleted_at' => NULL),
            array('id' => '15','subject_id' => '2','type' => 'multiple_choice','ques' => 'Paper, water, iron, Gold and milk are_____.','mark' => '2','image' => NULL,'created_at' => '2024-08-09 11:35:24','updated_at' => '2024-08-09 11:35:24','deleted_at' => NULL),
            array('id' => '16','subject_id' => '2','type' => 'multiple_choice','ques' => 'Choose the correct sentence.','mark' => '2','image' => NULL,'created_at' => '2024-08-09 11:39:02','updated_at' => '2024-08-09 11:39:02','deleted_at' => NULL),
            array('id' => '17','subject_id' => '2','type' => 'multiple_choice','ques' => 'What is the Synonym of \'Awful\'?','mark' => '2','image' => NULL,'created_at' => '2024-08-09 11:40:13','updated_at' => '2024-08-09 11:40:13','deleted_at' => NULL),
            array('id' => '18','subject_id' => '2','type' => 'multiple_choice','ques' => 'The word \'celebrate\' means_____','mark' => '2','image' => NULL,'created_at' => '2024-08-09 11:41:27','updated_at' => '2024-08-09 11:41:27','deleted_at' => NULL),
            array('id' => '19','subject_id' => '2','type' => 'multiple_choice','ques' => 'জোর যার মুল্লুক তার ।','mark' => '2','image' => NULL,'created_at' => '2024-08-09 11:42:56','updated_at' => '2024-08-09 11:42:56','deleted_at' => NULL),
            array('id' => '20','subject_id' => '2','type' => 'multiple_choice','ques' => 'We shall _____the work before he comes.','mark' => '2','image' => NULL,'created_at' => '2024-08-09 11:44:07','updated_at' => '2024-08-09 11:44:07','deleted_at' => NULL),
            array('id' => '21','subject_id' => '2','type' => 'multiple_choice','ques' => 'If I _____ you, I would never do it.','mark' => '2','image' => NULL,'created_at' => '2024-08-09 11:45:16','updated_at' => '2024-08-09 11:45:16','deleted_at' => NULL)
          );
          Question::insert($questions);
    }
}
