<?php

namespace Database\Seeders;

use App\Models\Category;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class CategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $mainCat1 = Category::create(['name' => 'Development', 'parent_id' => null]);
        $mainCat2 = Category::create(['name' => 'Business', 'parent_id' => null]);
        $mainCat3 = Category::create(['name' => 'Finance & Accounting', 'parent_id' => null]);
        $mainCat4 = Category::create(['name' => 'IT & Software', 'parent_id' => null]);
        $mainCat5 = Category::create(['name' => 'Office Productivity', 'parent_id' => null]);
        $mainCat6 = Category::create(['name' => 'Personal Development', 'parent_id' => null]);
        $mainCat7 = Category::create(['name' => 'Design', 'parent_id' => null]);
        $mainCat8 = Category::create(['name' => 'Marketing', 'parent_id' => null]);
        $mainCat9 = Category::create(['name' => 'Lifestyle', 'parent_id' => null]);
        $mainCat10 = Category::create(['name' => 'Photography & Video', 'parent_id' => null]);
        $mainCat11 = Category::create(['name' => 'Health & Fitness', 'parent_id' => null,]);
        $mainCat12 = Category::create(['name' => 'Music', 'parent_id' => null,]);
        $mainCat13 = Category::create(['name' => 'Teaching & Academic', 'parent_id' => null,]);



        $sub1Cat1 = Category::create(['name' => 'Web Development', 'parent_id' => 1]);
        $sub2Cat1 = Category::create(['name' => 'Data Science', 'parent_id' => 1]);
        $sub3Cat1 = Category::create(['name' => 'Mobile Development', 'parent_id' => 1]);
        $sub4Cat1 = Category::create(['name' => 'Programming Languages', 'parent_id' => 1]);
        $sub5Cat1 = Category::create(['name' => 'Game Development', 'parent_id' => 1]);
        $sub6Cat1 = Category::create(['name' => 'Database Design & Development', 'parent_id' => 1]);
        $sub7Cat1 = Category::create(['name' => 'Software Testing', 'parent_id' => 1]);
        $sub8Cat1 = Category::create(['name' => 'Software Engineering', 'parent_id' => 1]);
        $sub9Cat1 = Category::create(['name' => 'Software Development Tools', 'parent_id' => 1]);
        $sub10Cat1 = Category::create(['name' => 'No-Code Development', 'parent_id' => 1]);

        $sub1Cat2 = Category::create(['name' => 'Entrepreneurship', 'parent_id' => 2]);
        $sub2Cat2 = Category::create(['name' => 'Communication', 'parent_id' => 2]);
        $sub3Cat2 = Category::create(['name' => 'Management', 'parent_id' => 2]);
        $sub4Cat2 = Category::create(['name' => 'Sales', 'parent_id' => 2]);
        $sub5Cat2 = Category::create(['name' => 'Business Strategy', 'parent_id' => 2]);
        $sub6Cat2 = Category::create(['name' => 'Operations', 'parent_id' => 2]);
        $sub7Cat2 = Category::create(['name' => 'Project Management', 'parent_id' => 2]);
        $sub8Cat2 = Category::create(['name' => 'Business Law', 'parent_id' => 2]);
        $sub9Cat2 = Category::create(['name' => 'Business Analytics & Intelligence', 'parent_id' => 2]);
        $sub10Cat2 = Category::create(['name' => 'Human Resources', 'parent_id' => 2]);
        $sub11Cat2 = Category::create(['name' => 'Industry', 'parent_id' => 2]);
        $sub12Cat2 = Category::create(['name' => 'E-Commerce', 'parent_id' => 2]);
        $sub13Cat2 = Category::create(['name' => 'Media', 'parent_id' => 2]);
        $sub14Cat2 = Category::create(['name' => 'Real Estate', 'parent_id' => 2]);

        $sub1Cat3 = Category::create(['name' => 'Accounting & Bookkeeping', 'parent_id' => 3]);
        $sub2Cat3 = Category::create(['name' => 'Compliance', 'parent_id' => 3]);
        $sub3Cat3 = Category::create(['name' => 'Cryptocurrency & Blockchain', 'parent_id' => 3]);
        $sub4Cat3 = Category::create(['name' => 'Economics', 'parent_id' => 3]);
        $sub5Cat3 = Category::create(['name' => 'Finance Strategy', 'parent_id' => 3]);
        $sub6Cat3 = Category::create(['name' => 'Finance Cert & Exam Prep ', 'parent_id' => 3]);
        $sub7Cat3 = Category::create(['name' => 'Financial Modeling & Analysis', 'parent_id' => 3]);
        $sub8Cat3 = Category::create(['name' => 'Investing & Trading', 'parent_id' => 3]);
        $sub9Cat3 = Category::create(['name' => 'Money Management Tools', 'parent_id' => 3]);
        $sub10Cat3 = Category::create(['name' => 'Taxes', 'parent_id' => 3]);

        $sub1Cat4 = Category::create(['name' => 'IT Certifications', 'parent_id' => 4]);
        $sub2Cat4 = Category::create(['name' => 'Network & Security', 'parent_id' => 4]);
        $sub3Cat4 = Category::create(['name' => 'Hardware', 'parent_id' => 4]);
        $sub4Cat4 = Category::create(['name' => 'Operating Systems & Servers', 'parent_id' => 4]);
        $sub5Cat4 = Category::create(['name' => 'Other IT & Software', 'parent_id' => 4]);


        $sub1Cat5 = Category::create(['name' => 'Microsoft', 'parent_id' => 5]);
        $sub2Cat5 = Category::create(['name' => 'Apple', 'parent_id' => 5]);
        $sub3Cat5 = Category::create(['name' => 'Google', 'parent_id' => 5]);
        $sub4Cat5 = Category::create(['name' => 'SAP & Servers', 'parent_id' => 5]);
        $sub5Cat5 = Category::create(['name' => 'Oracle', 'parent_id' => 5]);
        $sub6Cat5 = Category::create(['name' => 'Other Office Productivity', 'parent_id' => 5]);


        $sub1Cat6 = Category::create(['name' => 'Personal Transformation', 'parent_id' => 6]);
        $sub2Cat6 = Category::create(['name' => 'Personal Productivity', 'parent_id' => 6]);
        $sub3Cat6 = Category::create(['name' => 'Leadership', 'parent_id' => 6]);
        $sub4Cat6 = Category::create(['name' => 'Career Development', 'parent_id' => 6]);
        $sub5Cat6 = Category::create(['name' => 'Parenting & Relationships', 'parent_id' => 6]);
        $sub6Cat6 = Category::create(['name' => 'Happiness', 'parent_id' => 6]);
        $sub7Cat6 = Category::create(['name' => 'Esoteric Practices', 'parent_id' => 6]);
        $sub8Cat6 = Category::create(['name' => 'Religion & Spirituality', 'parent_id' => 6]);
        $sub9Cat6 = Category::create(['name' => 'Personal Brand Building', 'parent_id' => 6]);
        $sub10Cat6 = Category::create(['name' => 'Creativity', 'parent_id' => 6]);
        $sub11Cat6 = Category::create(['name' => 'Influence', 'parent_id' => 6]);
        $sub12Cat6 = Category::create(['name' => 'Self Esteem & Confidence', 'parent_id' => 6]);
        $sub13Cat6 = Category::create(['name' => 'Stress Management', 'parent_id' => 6]);
        $sub14Cat6 = Category::create(['name' => 'Memory & Study Skills', 'parent_id' => 6]);
        $sub15Cat6 = Category::create(['name' => 'Motivation', 'parent_id' => 6]);


        $sub1Cat7 = Category::create(['name' => 'Web Design', 'parent_id' => 7]);
        $sub2Cat7 = Category::create(['name' => 'Graphic Design & Illustration', 'parent_id' => 7]);
        $sub3Cat7 = Category::create(['name' => 'Design Tools', 'parent_id' => 7]);
        $sub4Cat7 = Category::create(['name' => 'User Experience Design', 'parent_id' => 7]);
        $sub5Cat7 = Category::create(['name' => 'Game Design & Relationships', 'parent_id' => 7]);
        $sub6Cat7 = Category::create(['name' => '3D & Animation', 'parent_id' => 7]);
        $sub7Cat7 = Category::create(['name' => 'Fashion Design', 'parent_id' => 7]);
        $sub8Cat7 = Category::create(['name' => 'Architectural Design', 'parent_id' => 7]);
        $sub9Cat7 = Category::create(['name' => 'Interior Design', 'parent_id' => 7]);


        $sub0Cat8 = Category::create(['name' => 'Digital Marketing', 'parent_id' => 8,]);
        $sub1Cat8 = Category::create(['name' => 'Search Engine Optimization', 'parent_id' => 8]);
        $sub2Cat8 = Category::create(['name' => 'Social Media Marketing', 'parent_id' => 8]);
        $sub3Cat8 = Category::create(['name' => 'Branding', 'parent_id' => 8]);
        $sub4Cat8 = Category::create(['name' => 'Marketing Fundamentals', 'parent_id' => 8]);
        $sub5Cat8 = Category::create(['name' => 'Marketing Analytics & Automation', 'parent_id' => 8]);
        $sub6Cat8 = Category::create(['name' => 'Public Relations', 'parent_id' => 8]);
        $sub7Cat8 = Category::create(['name' => 'Paid Advertising', 'parent_id' => 8]);
        $sub8Cat8 = Category::create(['name' => 'Video & Mobile Marketing', 'parent_id' => 8]);
        $sub9Cat8 = Category::create(['name' => 'Content Marketing', 'parent_id' => 8]);
        $sub10Cat8 = Category::create(['name' => 'Growth Hacking', 'parent_id' => 8]);
        $sub11Cat8 = Category::create(['name' => 'Affiliate Marketing', 'parent_id' => 8]);
        $sub12Cat8 = Category::create(['name' => 'Product Marketing', 'parent_id' => 8]);
        $sub13Cat8 = Category::create(['name' => 'Other Marketing', 'parent_id' => 8]);


        $sub0Cat9 = Category::create(['name' => 'Arts & Crafts', 'parent_id' => 9]);
        $sub1Cat9 = Category::create(['name' => 'Beauty & Makeup', 'parent_id' => 9]);
        $sub2Cat9 = Category::create(['name' => 'Esoteric Practices', 'parent_id' => 9]);
        $sub3Cat9 = Category::create(['name' => 'Food & Beverage', 'parent_id' => 9]);
        $sub4Cat9 = Category::create(['name' => 'Gaming', 'parent_id' => 9]);
        $sub5Cat9 = Category::create(['name' => 'Home Improvement & Gardening', 'parent_id' => 9]);
        $sub6Cat9 = Category::create(['name' => 'Pet Care & Training', 'parent_id' => 9]);
        $sub7Cat9 = Category::create(['name' => 'Travel', 'parent_id' => 9]);
        $sub8Cat9 = Category::create(['name' => 'Other Lifestyle', 'parent_id' => 9]);


        $sub1Cat10 = Category::create(['name' => 'Digital Photography', 'parent_id' => 10]);
        $sub2Cat10 = Category::create(['name' => 'Photography', 'parent_id' => 10]);
        $sub3Cat10 = Category::create(['name' => 'Portrait Photography', 'parent_id' => 10]);
        $sub4Cat10 = Category::create(['name' => 'Photography Tools', 'parent_id' => 10]);
        $sub5Cat10 = Category::create(['name' => 'Commercial Photography', 'parent_id' => 10]);
        $sub6Cat10 = Category::create(['name' => 'Video Design', 'parent_id' => 10]);
        $sub7Cat10 = Category::create(['name' => 'Other Photography & Video', 'parent_id' => 10]);


        $sub1Cat11 = Category::create(['name' => 'Fitness', 'parent_id' => 11]);
        $sub2Cat11 = Category::create(['name' => 'General Health', 'parent_id' => 11]);
        $sub3Cat11 = Category::create(['name' => 'Sports', 'parent_id' => 11]);
        $sub4Cat11 = Category::create(['name' => 'Nutrition & Diet', 'parent_id' => 11]);
        $sub5Cat11 = Category::create(['name' => 'Yoga', 'parent_id' => 11]);
        $sub6Cat11 = Category::create(['name' => 'Mental Health', 'parent_id' => 11]);
        $sub7Cat11 = Category::create(['name' => 'Martial Arts & Self Defense', 'parent_id' => 11]);
        $sub8Cat11 = Category::create(['name' => 'Safety & First Aid', 'parent_id' => 11]);
        $sub9Cat11 = Category::create(['name' => 'Meditation', 'parent_id' => 11]);


        $sub1Cat12 = Category::create(['name' => 'Instruments', 'parent_id' => 12]);
        $sub2Cat12 = Category::create(['name' => 'Music Production', 'parent_id' => 12]);
        $sub3Cat12 = Category::create(['name' => 'Music Fundamentals', 'parent_id' => 12]);
        $sub4Cat12 = Category::create(['name' => 'Vocal', 'parent_id' => 12]);
        $sub5Cat12 = Category::create(['name' => 'Music Techniques', 'parent_id' => 12]);
        $sub6Cat12 = Category::create(['name' => 'Music Software', 'parent_id' => 12]);

        $sub1Cat13 = Category::create(['name' => 'Engineering', 'parent_id' => 13]);
        $sub2Cat13 = Category::create(['name' => 'Humanities', 'parent_id' => 13]);
        $sub3Cat13 = Category::create(['name' => 'Math', 'parent_id' => 13]);
        $sub4Cat13 = Category::create(['name' => 'Science', 'parent_id' => 13]);
        $sub5Cat13 = Category::create(['name' => 'Online Education', 'parent_id' => 13]);
        $sub6Cat13 = Category::create(['name' => 'Social Science', 'parent_id' => 13]);
        $sub7Cat13 = Category::create(['name' => 'Language Learning', 'parent_id' => 13]);
        $sub8Cat13 = Category::create(['name' => 'Teacher Training', 'parent_id' => 13]);
        $sub9Cat13 = Category::create(['name' => 'Test Prep', 'parent_id' => 13]);



















    }
}
