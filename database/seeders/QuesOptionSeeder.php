<?php

namespace Database\Seeders;

use App\Models\QuesOption;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class QuesOptionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $ques_options = array(
            array('id' => '1','question_id' => '1','option' => '2','correct' => NULL,'created_at' => '2024-08-09 10:58:44','updated_at' => '2024-08-09 10:58:44','deleted_at' => NULL),
            array('id' => '2','question_id' => '1','option' => '3','correct' => NULL,'created_at' => '2024-08-09 10:58:44','updated_at' => '2024-08-09 10:58:44','deleted_at' => NULL),
            array('id' => '3','question_id' => '1','option' => '4','correct' => NULL,'created_at' => '2024-08-09 10:58:44','updated_at' => '2024-08-09 10:58:44','deleted_at' => NULL),
            array('id' => '4','question_id' => '1','option' => '5','correct' => NULL,'created_at' => '2024-08-09 10:58:44','updated_at' => '2024-08-09 10:58:44','deleted_at' => NULL),
            array('id' => '5','question_id' => '2','option' => 'কার','correct' => NULL,'created_at' => '2024-08-09 11:02:54','updated_at' => '2024-08-09 11:02:54','deleted_at' => NULL),
            array('id' => '6','question_id' => '2','option' => 'অনুবর্ণ','correct' => NULL,'created_at' => '2024-08-09 11:02:54','updated_at' => '2024-08-09 11:02:54','deleted_at' => NULL),
            array('id' => '7','question_id' => '2','option' => 'ফলা','correct' => NULL,'created_at' => '2024-08-09 11:02:54','updated_at' => '2024-08-09 11:02:54','deleted_at' => NULL),
            array('id' => '8','question_id' => '2','option' => 'রেফ','correct' => NULL,'created_at' => '2024-08-09 11:02:54','updated_at' => '2024-08-09 11:02:54','deleted_at' => NULL),
            array('id' => '9','question_id' => '3','option' => 'রূপতত্ত্ব','correct' => NULL,'created_at' => '2024-08-09 11:07:39','updated_at' => '2024-08-09 11:07:39','deleted_at' => NULL),
            array('id' => '10','question_id' => '3','option' => 'ধ্বনিতত্ত্ব','correct' => NULL,'created_at' => '2024-08-09 11:07:39','updated_at' => '2024-08-09 11:07:39','deleted_at' => NULL),
            array('id' => '11','question_id' => '3','option' => 'পদক্রম','correct' => NULL,'created_at' => '2024-08-09 11:07:39','updated_at' => '2024-08-09 11:07:39','deleted_at' => NULL),
            array('id' => '12','question_id' => '3','option' => 'বাক্য প্রকরণ','correct' => NULL,'created_at' => '2024-08-09 11:07:39','updated_at' => '2024-08-09 11:07:39','deleted_at' => NULL),
            array('id' => '13','question_id' => '4','option' => 'মুলা','correct' => NULL,'created_at' => '2024-08-09 11:09:42','updated_at' => '2024-08-09 11:09:42','deleted_at' => NULL),
            array('id' => '14','question_id' => '4','option' => 'চাবি','correct' => NULL,'created_at' => '2024-08-09 11:09:42','updated_at' => '2024-08-09 11:09:42','deleted_at' => NULL),
            array('id' => '15','question_id' => '4','option' => 'চাকর','correct' => NULL,'created_at' => '2024-08-09 11:09:42','updated_at' => '2024-08-09 11:09:42','deleted_at' => NULL),
            array('id' => '16','question_id' => '4','option' => 'চামার','correct' => NULL,'created_at' => '2024-08-09 11:09:42','updated_at' => '2024-08-09 11:09:42','deleted_at' => NULL),
            array('id' => '17','question_id' => '6','option' => 'সর্বনাম','correct' => NULL,'created_at' => '2024-08-09 11:12:42','updated_at' => '2024-08-09 11:12:42','deleted_at' => NULL),
            array('id' => '18','question_id' => '6','option' => 'বিশেষণ','correct' => NULL,'created_at' => '2024-08-09 11:12:42','updated_at' => '2024-08-09 11:12:42','deleted_at' => NULL),
            array('id' => '19','question_id' => '6','option' => 'অনুসর্গ','correct' => NULL,'created_at' => '2024-08-09 11:12:42','updated_at' => '2024-08-09 11:12:42','deleted_at' => NULL),
            array('id' => '20','question_id' => '6','option' => 'ক্রিয়া','correct' => NULL,'created_at' => '2024-08-09 11:12:42','updated_at' => '2024-08-09 11:12:42','deleted_at' => NULL),
            array('id' => '21','question_id' => '7','option' => 'আমি','correct' => NULL,'created_at' => '2024-08-09 11:14:43','updated_at' => '2024-08-09 11:14:43','deleted_at' => NULL),
            array('id' => '22','question_id' => '7','option' => 'বইগুলি','correct' => NULL,'created_at' => '2024-08-09 11:14:43','updated_at' => '2024-08-09 11:14:43','deleted_at' => NULL),
            array('id' => '23','question_id' => '7','option' => 'মাঝিরা','correct' => NULL,'created_at' => '2024-08-09 11:14:43','updated_at' => '2024-08-09 11:14:43','deleted_at' => NULL),
            array('id' => '24','question_id' => '7','option' => 'কলমগুলো','correct' => NULL,'created_at' => '2024-08-09 11:14:43','updated_at' => '2024-08-09 11:14:43','deleted_at' => NULL),
            array('id' => '25','question_id' => '8','option' => 'বাক্যের অর্থ','correct' => NULL,'created_at' => '2024-08-09 11:18:09','updated_at' => '2024-08-09 11:18:09','deleted_at' => NULL),
            array('id' => '26','question_id' => '8','option' => 'বাক্যের প্রকাশ ভঙ্গি','correct' => NULL,'created_at' => '2024-08-09 11:18:09','updated_at' => '2024-08-09 11:18:09','deleted_at' => NULL),
            array('id' => '27','question_id' => '8','option' => 'বাক্যের ভাব','correct' => NULL,'created_at' => '2024-08-09 11:18:09','updated_at' => '2024-08-09 11:18:09','deleted_at' => NULL),
            array('id' => '28','question_id' => '8','option' => 'বাক্যের প্রয়োগ','correct' => NULL,'created_at' => '2024-08-09 11:18:09','updated_at' => '2024-08-09 11:18:09','deleted_at' => NULL),
            array('id' => '29','question_id' => '9','option' => 'নীরোগ শরীর','correct' => NULL,'created_at' => '2024-08-09 11:21:16','updated_at' => '2024-08-09 11:21:16','deleted_at' => NULL),
            array('id' => '30','question_id' => '9','option' => 'প্রভাব শালী','correct' => NULL,'created_at' => '2024-08-09 11:21:16','updated_at' => '2024-08-09 11:21:16','deleted_at' => NULL),
            array('id' => '31','question_id' => '9','option' => 'যা সহজে মরে না','correct' => NULL,'created_at' => '2024-08-09 11:21:16','updated_at' => '2024-08-09 11:21:16','deleted_at' => NULL),
            array('id' => '32','question_id' => '9','option' => 'ধামাধরা','correct' => NULL,'created_at' => '2024-08-09 11:21:16','updated_at' => '2024-08-09 11:21:16','deleted_at' => NULL),
            array('id' => '33','question_id' => '10','option' => 'উদ্বাহ','correct' => NULL,'created_at' => '2024-08-09 11:23:58','updated_at' => '2024-08-09 11:23:58','deleted_at' => NULL),
            array('id' => '34','question_id' => '10','option' => 'নিকা','correct' => NULL,'created_at' => '2024-08-09 11:23:58','updated_at' => '2024-08-09 11:23:58','deleted_at' => NULL),
            array('id' => '35','question_id' => '10','option' => 'পাট্টা','correct' => NULL,'created_at' => '2024-08-09 11:23:58','updated_at' => '2024-08-09 11:23:58','deleted_at' => NULL),
            array('id' => '36','question_id' => '10','option' => 'পরিণয়','correct' => NULL,'created_at' => '2024-08-09 11:23:58','updated_at' => '2024-08-09 11:23:58','deleted_at' => NULL),
            array('id' => '37','question_id' => '11','option' => 'দেশ-কাল-পাত্র','correct' => NULL,'created_at' => '2024-08-09 11:27:11','updated_at' => '2024-08-09 11:27:11','deleted_at' => NULL),
            array('id' => '38','question_id' => '11','option' => 'মসজিদ-মন্দির','correct' => NULL,'created_at' => '2024-08-09 11:27:11','updated_at' => '2024-08-09 11:27:11','deleted_at' => NULL),
            array('id' => '39','question_id' => '11','option' => 'ধনী-দরিদ্র','correct' => NULL,'created_at' => '2024-08-09 11:27:11','updated_at' => '2024-08-09 11:27:11','deleted_at' => NULL),
            array('id' => '40','question_id' => '11','option' => 'মোল্লা-পুরোহিত','correct' => NULL,'created_at' => '2024-08-09 11:27:11','updated_at' => '2024-08-09 11:27:11','deleted_at' => NULL),
            array('id' => '41','question_id' => '12','option' => 'Illustrious','correct' => NULL,'created_at' => '2024-08-09 11:31:19','updated_at' => '2024-08-09 11:31:19','deleted_at' => NULL),
            array('id' => '42','question_id' => '12','option' => 'Heroic','correct' => NULL,'created_at' => '2024-08-09 11:31:19','updated_at' => '2024-08-09 11:31:19','deleted_at' => NULL),
            array('id' => '43','question_id' => '12','option' => 'Mythical','correct' => NULL,'created_at' => '2024-08-09 11:31:19','updated_at' => '2024-08-09 11:31:19','deleted_at' => NULL),
            array('id' => '44','question_id' => '12','option' => 'Historical','correct' => NULL,'created_at' => '2024-08-09 11:31:19','updated_at' => '2024-08-09 11:31:19','deleted_at' => NULL),
            array('id' => '45','question_id' => '13','option' => 'A','correct' => NULL,'created_at' => '2024-08-09 11:32:45','updated_at' => '2024-08-09 11:32:45','deleted_at' => NULL),
            array('id' => '46','question_id' => '13','option' => 'An','correct' => NULL,'created_at' => '2024-08-09 11:32:45','updated_at' => '2024-08-09 11:32:45','deleted_at' => NULL),
            array('id' => '47','question_id' => '13','option' => 'The','correct' => NULL,'created_at' => '2024-08-09 11:32:45','updated_at' => '2024-08-09 11:32:45','deleted_at' => NULL),
            array('id' => '48','question_id' => '13','option' => 'X','correct' => NULL,'created_at' => '2024-08-09 11:32:45','updated_at' => '2024-08-09 11:32:45','deleted_at' => NULL),
            array('id' => '49','question_id' => '14','option' => 'To','correct' => NULL,'created_at' => '2024-08-09 11:33:48','updated_at' => '2024-08-09 11:33:48','deleted_at' => NULL),
            array('id' => '50','question_id' => '14','option' => 'From','correct' => NULL,'created_at' => '2024-08-09 11:33:48','updated_at' => '2024-08-09 11:33:48','deleted_at' => NULL),
            array('id' => '51','question_id' => '14','option' => 'By','correct' => NULL,'created_at' => '2024-08-09 11:33:48','updated_at' => '2024-08-09 11:33:48','deleted_at' => NULL),
            array('id' => '52','question_id' => '14','option' => 'Off','correct' => NULL,'created_at' => '2024-08-09 11:33:48','updated_at' => '2024-08-09 11:33:48','deleted_at' => NULL),
            array('id' => '53','question_id' => '15','option' => 'Material Noun','correct' => NULL,'created_at' => '2024-08-09 11:35:24','updated_at' => '2024-08-09 11:35:24','deleted_at' => NULL),
            array('id' => '54','question_id' => '15','option' => 'Abstract Noun','correct' => NULL,'created_at' => '2024-08-09 11:35:24','updated_at' => '2024-08-09 11:35:24','deleted_at' => NULL),
            array('id' => '55','question_id' => '15','option' => 'Common Noun','correct' => NULL,'created_at' => '2024-08-09 11:35:24','updated_at' => '2024-08-09 11:35:24','deleted_at' => NULL),
            array('id' => '56','question_id' => '15','option' => 'Collective Noun','correct' => NULL,'created_at' => '2024-08-09 11:35:24','updated_at' => '2024-08-09 11:35:24','deleted_at' => NULL),
            array('id' => '57','question_id' => '16','option' => 'What is the time in your watch?','correct' => NULL,'created_at' => '2024-08-09 11:39:02','updated_at' => '2024-08-09 11:39:02','deleted_at' => NULL),
            array('id' => '58','question_id' => '16','option' => 'What is the time by your watch?','correct' => NULL,'created_at' => '2024-08-09 11:39:02','updated_at' => '2024-08-09 11:39:02','deleted_at' => NULL),
            array('id' => '59','question_id' => '16','option' => 'What is the time into your watch?','correct' => NULL,'created_at' => '2024-08-09 11:39:02','updated_at' => '2024-08-09 11:39:02','deleted_at' => NULL),
            array('id' => '60','question_id' => '16','option' => 'What is the time at your watch?','correct' => NULL,'created_at' => '2024-08-09 11:39:02','updated_at' => '2024-08-09 11:39:02','deleted_at' => NULL),
            array('id' => '61','question_id' => '17','option' => 'Cheap','correct' => NULL,'created_at' => '2024-08-09 11:40:13','updated_at' => '2024-08-09 11:40:13','deleted_at' => NULL),
            array('id' => '62','question_id' => '17','option' => 'Dreadful','correct' => NULL,'created_at' => '2024-08-09 11:40:13','updated_at' => '2024-08-09 11:40:13','deleted_at' => NULL),
            array('id' => '63','question_id' => '17','option' => 'Horrible','correct' => NULL,'created_at' => '2024-08-09 11:40:13','updated_at' => '2024-08-09 11:40:13','deleted_at' => NULL),
            array('id' => '64','question_id' => '17','option' => 'Shocking','correct' => NULL,'created_at' => '2024-08-09 11:40:13','updated_at' => '2024-08-09 11:40:13','deleted_at' => NULL),
            array('id' => '65','question_id' => '18','option' => 'Honour','correct' => NULL,'created_at' => '2024-08-09 11:41:27','updated_at' => '2024-08-09 11:41:27','deleted_at' => NULL),
            array('id' => '66','question_id' => '18','option' => 'Observe','correct' => NULL,'created_at' => '2024-08-09 11:41:27','updated_at' => '2024-08-09 11:41:27','deleted_at' => NULL),
            array('id' => '67','question_id' => '18','option' => 'Remember','correct' => NULL,'created_at' => '2024-08-09 11:41:27','updated_at' => '2024-08-09 11:41:27','deleted_at' => NULL),
            array('id' => '68','question_id' => '18','option' => 'Revere','correct' => NULL,'created_at' => '2024-08-09 11:41:27','updated_at' => '2024-08-09 11:41:27','deleted_at' => NULL),
            array('id' => '69','question_id' => '19','option' => 'Might is right','correct' => NULL,'created_at' => '2024-08-09 11:42:56','updated_at' => '2024-08-09 11:42:56','deleted_at' => NULL),
            array('id' => '70','question_id' => '19','option' => 'Right is might','correct' => NULL,'created_at' => '2024-08-09 11:42:56','updated_at' => '2024-08-09 11:42:56','deleted_at' => NULL),
            array('id' => '71','question_id' => '19','option' => 'Might are right','correct' => NULL,'created_at' => '2024-08-09 11:42:56','updated_at' => '2024-08-09 11:42:56','deleted_at' => NULL),
            array('id' => '72','question_id' => '19','option' => 'None of above','correct' => NULL,'created_at' => '2024-08-09 11:42:56','updated_at' => '2024-08-09 11:42:56','deleted_at' => NULL),
            array('id' => '73','question_id' => '20','option' => 'Finish','correct' => NULL,'created_at' => '2024-08-09 11:44:07','updated_at' => '2024-08-09 11:44:07','deleted_at' => NULL),
            array('id' => '74','question_id' => '20','option' => 'Have finished','correct' => NULL,'created_at' => '2024-08-09 11:44:07','updated_at' => '2024-08-09 11:44:07','deleted_at' => NULL),
            array('id' => '75','question_id' => '20','option' => 'Finished','correct' => NULL,'created_at' => '2024-08-09 11:44:07','updated_at' => '2024-08-09 11:44:07','deleted_at' => NULL),
            array('id' => '76','question_id' => '20','option' => 'Be finishing','correct' => NULL,'created_at' => '2024-08-09 11:44:07','updated_at' => '2024-08-09 11:44:07','deleted_at' => NULL),
            array('id' => '77','question_id' => '21','option' => 'Was','correct' => NULL,'created_at' => '2024-08-09 11:45:16','updated_at' => '2024-08-09 11:45:16','deleted_at' => NULL),
            array('id' => '78','question_id' => '21','option' => 'Were','correct' => NULL,'created_at' => '2024-08-09 11:45:16','updated_at' => '2024-08-09 11:45:16','deleted_at' => NULL),
            array('id' => '79','question_id' => '21','option' => 'Had been','correct' => NULL,'created_at' => '2024-08-09 11:45:16','updated_at' => '2024-08-09 11:45:16','deleted_at' => NULL),
            array('id' => '80','question_id' => '21','option' => 'Have been','correct' => NULL,'created_at' => '2024-08-09 11:45:16','updated_at' => '2024-08-09 11:45:16','deleted_at' => NULL)
          );
          QuesOption::insert($ques_options);
    }
}
