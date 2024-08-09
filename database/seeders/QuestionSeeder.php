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
            array('id' => '21','subject_id' => '2','type' => 'multiple_choice','ques' => 'If I _____ you, I would never do it.','mark' => '2','image' => NULL,'created_at' => '2024-08-09 11:45:16','updated_at' => '2024-08-09 11:45:16','deleted_at' => NULL),
            array('id' => '22','subject_id' => '3','type' => 'multiple_choice','ques' => 'ট্রাপিজিয়ামের চার কোণের সমষ্টি কত?','mark' => '2','image' => NULL,'created_at' => '2024-08-09 12:22:07','updated_at' => '2024-08-09 12:22:07','deleted_at' => NULL),
            array('id' => '23','subject_id' => '3','type' => 'multiple_choice','ques' => 'ট্রাপিজিয়ামের চার কোণের সমষ্টি কত?','mark' => '2','image' => NULL,'created_at' => '2024-08-09 17:51:55','updated_at' => '2024-08-09 17:51:55','deleted_at' => NULL),
            array('id' => '24','subject_id' => '3','type' => 'multiple_choice','ques' => 'যদি  x+y =3 এবং x-y =1 হয় তবে x2+y2 = কত ?','mark' => '2','image' => NULL,'created_at' => '2024-08-09 17:52:53','updated_at' => '2024-08-09 17:52:53','deleted_at' => NULL),
            array('id' => '25','subject_id' => '3','type' => 'multiple_choice','ques' => 'cot⁡(θ-60°)=√3  হলে  sinθ =  কত ?','mark' => '2','image' => NULL,'created_at' => '2024-08-09 17:56:01','updated_at' => '2024-08-09 17:56:01','deleted_at' => NULL),
            array('id' => '26','subject_id' => '3','type' => 'multiple_choice','ques' => '15 হতে 20 এর মধ্যে মৌলিক সংখ্যার পার্থক্য কত ?','mark' => '2','image' => NULL,'created_at' => '2024-08-09 18:00:10','updated_at' => '2024-08-09 18:00:10','deleted_at' => NULL),
            array('id' => '27','subject_id' => '3','type' => 'multiple_choice','ques' => 'A={e, f, r}  এবং B= {c, d, e, r} হলে , A∩B = কত ?','mark' => '2','image' => NULL,'created_at' => '2024-08-09 20:19:27','updated_at' => '2024-08-09 20:19:27','deleted_at' => NULL),
            array('id' => '28','subject_id' => '3','type' => 'multiple_choice','ques' => 'একটি ত্রিভুজের ক্ষেত্রফল 16 বর্গমিটার এবং উচ্চতা 4 মিটার হলে ভূমির দৈর্ঘ্য কত মিটার ?','mark' => '2','image' => NULL,'created_at' => '2024-08-09 20:21:54','updated_at' => '2024-08-09 20:21:54','deleted_at' => NULL),
            array('id' => '29','subject_id' => '3','type' => 'multiple_choice','ques' => 'একটি নৌকার প্রকৃত গতিবেগ 4 কি.মি./ঘণ্টা হলে নৌকাটি স্থির পানিতে 1 ঘণ্টায় কত দূরত্ব অতিক্রম করবে?','mark' => '2','image' => NULL,'created_at' => '2024-08-09 20:25:13','updated_at' => '2024-08-09 20:25:13','deleted_at' => NULL),
            array('id' => '30','subject_id' => '3','type' => 'multiple_choice','ques' => 'এক বাক্স চা পাতা কেজি প্রতি 75 টাকা হিসেবে ক্রয় করে, কেজি প্রতি 70টাকা দরে বিক্রয় করা হয়। মোট 500 টাকা ক্ষতি হলে,মোট চা পাতা কত কেজি ?','mark' => '2','image' => NULL,'created_at' => '2024-08-09 20:28:31','updated_at' => '2024-08-09 20:28:31','deleted_at' => NULL),
            array('id' => '31','subject_id' => '3','type' => 'multiple_choice','ques' => '10x+12y = 9 সমীকরণটিতে কয়টি চলক আছে ?','mark' => '2','image' => NULL,'created_at' => '2024-08-09 20:29:50','updated_at' => '2024-08-09 20:29:50','deleted_at' => NULL),
            array('id' => '32','subject_id' => '4','type' => 'multiple_choice','ques' => 'সর্বপ্রথম সূর্য কেন্দ্রিক সৌরজগতের ধারণা দেন কোন বিজ্ঞানী ?','mark' => '2','image' => NULL,'created_at' => '2024-08-09 20:32:53','updated_at' => '2024-08-09 20:32:53','deleted_at' => NULL),
            array('id' => '33','subject_id' => '4','type' => 'multiple_choice','ques' => 'আইনস্টাইন তাঁর কোন তত্ত্ব থেকে  E =mc^2  সমীকরণটি প্রতিপাদন করেন?','mark' => '2','image' => NULL,'created_at' => '2024-08-09 20:35:56','updated_at' => '2024-08-09 20:35:56','deleted_at' => NULL),
            array('id' => '34','subject_id' => '4','type' => 'multiple_choice','ques' => 'বাংলাদেশে প্রথম নিউক্লিয়ার বিদ্যুৎ কেন্দ্র হতে যাচ্ছে কোথায় ?','mark' => '2','image' => NULL,'created_at' => '2024-08-09 20:38:53','updated_at' => '2024-08-09 20:38:53','deleted_at' => NULL),
            array('id' => '35','subject_id' => '4','type' => 'multiple_choice','ques' => 'কোন যন্ত্রের সাহায্যে সরাসরি নিখুঁতভাবে দৈর্ঘ্য মাপা যায় ?','mark' => '2','image' => NULL,'created_at' => '2024-08-09 20:41:31','updated_at' => '2024-08-09 20:41:31','deleted_at' => NULL),
            array('id' => '36','subject_id' => '4','type' => 'multiple_choice','ques' => 'একটি বস্তুকে উপর হতে ছেড়ে দিলে কোন বলের প্রভাবে তা নিচের দিকে পড়তে থাকবে ?','mark' => '2','image' => NULL,'created_at' => '2024-08-09 20:44:09','updated_at' => '2024-08-09 20:44:09','deleted_at' => NULL),
            array('id' => '37','subject_id' => '4','type' => 'multiple_choice','ques' => 'একটি পাথর ও একটি পাখির পালক একই উচ্চতা থেকে একই সময়ে ছেড়ে দেওয়া হলে?','mark' => '2','image' => NULL,'created_at' => '2024-08-09 20:47:53','updated_at' => '2024-08-09 20:47:53','deleted_at' => NULL),
            array('id' => '38','subject_id' => '4','type' => 'multiple_choice','ques' => 'প্রাকৃতিক পলিমার কোনটি ?','mark' => '2','image' => NULL,'created_at' => '2024-08-09 20:49:20','updated_at' => '2024-08-09 20:49:20','deleted_at' => NULL),
            array('id' => '39','subject_id' => '4','type' => 'multiple_choice','ques' => 'মানুষের লোহিত রক্ত কণিকার আয়ু কতদিন ?','mark' => '2','image' => NULL,'created_at' => '2024-08-09 20:51:04','updated_at' => '2024-08-09 20:51:04','deleted_at' => NULL),
            array('id' => '40','subject_id' => '4','type' => 'multiple_choice','ques' => 'কোন প্রক্রিয়ায় রক্ত হতে ফুসফুসে অক্সিজেন পরিবাহিত হয়?','mark' => '2','image' => NULL,'created_at' => '2024-08-09 20:53:19','updated_at' => '2024-08-09 20:53:19','deleted_at' => NULL),
            array('id' => '41','subject_id' => '4','type' => 'multiple_choice','ques' => 'কোনটির জন্য প্রাণী উদ্ভিদের উপর নির্ভরশীল ?','mark' => '2','image' => NULL,'created_at' => '2024-08-09 20:55:04','updated_at' => '2024-08-09 20:55:04','deleted_at' => NULL),
            array('id' => '42','subject_id' => '5','type' => 'multiple_choice','ques' => 'ইন্দোনেশিয়ার রাজধানীর নাম কী ?','mark' => '2','image' => NULL,'created_at' => '2024-08-09 20:57:15','updated_at' => '2024-08-09 20:57:15','deleted_at' => NULL),
            array('id' => '43','subject_id' => '5','type' => 'multiple_choice','ques' => 'বাংলাদেশের অস্থায়ী সরকারের প্রধান কে ছিলেন ?','mark' => '2','image' => NULL,'created_at' => '2024-08-09 21:00:36','updated_at' => '2024-08-09 21:00:36','deleted_at' => NULL),
            array('id' => '44','subject_id' => '5','type' => 'multiple_choice','ques' => 'আন্তর্জাতিক মাতৃভাষা দিবস উপলক্ষে প্রথম বারের মতো কোন দেশ বাংলাদেশের কেন্দ্রীয় শহীদ মিনারের ছবি সমন্বিত ডাকটিকেট প্রকাশ করে ?','mark' => '2','image' => NULL,'created_at' => '2024-08-09 21:03:41','updated_at' => '2024-08-09 21:03:41','deleted_at' => NULL),
            array('id' => '45','subject_id' => '5','type' => 'multiple_choice','ques' => 'পৃথিবীর বৃহত্তম সমুদ্র সৈকত কোনটি ?','mark' => '2','image' => NULL,'created_at' => '2024-08-09 21:06:23','updated_at' => '2024-08-09 21:06:23','deleted_at' => NULL),
            array('id' => '46','subject_id' => '5','type' => 'multiple_choice','ques' => '৩৬৫ দিনে বছর  ৩০ দিনে মাস গণনা কারা শুরু করেন ?','mark' => '2','image' => NULL,'created_at' => '2024-08-09 21:09:15','updated_at' => '2024-08-09 21:09:15','deleted_at' => NULL),
            array('id' => '47','subject_id' => '5','type' => 'multiple_choice','ques' => 'মোতাহের হোসেন চৌধুরী কোন পেশায় নিয়োজিত ছিলেন ?','mark' => '2','image' => NULL,'created_at' => '2024-08-09 21:11:27','updated_at' => '2024-08-09 21:11:27','deleted_at' => NULL),
            array('id' => '48','subject_id' => '5','type' => 'multiple_choice','ques' => 'BIRIএর পূর্ণরূপ কী ?','mark' => '-12','image' => NULL,'created_at' => '2024-08-09 21:14:10','updated_at' => '2024-08-09 21:14:10','deleted_at' => NULL),
            array('id' => '49','subject_id' => '5','type' => 'multiple_choice','ques' => '৩, ৫, ১৫, ২৩ ,.......ধারার পরের সংখ্যাটি কি?','mark' => '2','image' => NULL,'created_at' => '2024-08-09 21:16:12','updated_at' => '2024-08-09 21:16:12','deleted_at' => NULL),
            array('id' => '50','subject_id' => '5','type' => 'multiple_choice','ques' => 'বিশ্বকাপ ফুটবলে \'গোল্ডেন বল\' চালু হয় কবে?','mark' => '2','image' => NULL,'created_at' => '2024-08-09 21:18:44','updated_at' => '2024-08-09 21:18:44','deleted_at' => NULL),
            array('id' => '51','subject_id' => '5','type' => 'multiple_choice','ques' => 'বাংলাদেশের জাতীয় কবির নাম কী ?','mark' => '2','image' => NULL,'created_at' => '2024-08-09 21:20:40','updated_at' => '2024-08-09 21:20:40','deleted_at' => NULL)
          );

          Question::insert($questions);
    }
}
