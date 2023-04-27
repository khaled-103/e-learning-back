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
        Category::create(['name' => 'Development', 'parent_id' => null]);
        Category::create(['name' => 'Business', 'parent_id' => null]);
        Category::create(['name' => 'Finance & Accounting', 'parent_id' => null]);
        Category::create(['name' => 'IT & Software', 'parent_id' => null]);
        Category::create(['name' => 'Office Productivity', 'parent_id' => null]);
        Category::create(['name' => 'Personal Development', 'parent_id' => null]);
        Category::create(['name' => 'Design', 'parent_id' => null]);
        Category::create(['name' => 'Marketing', 'parent_id' => null]);
        Category::create(['name' => 'Lifestyle', 'parent_id' => null]);
         Category::create(['name' => 'Photography & Video', 'parent_id' => null]);
         Category::create(['name' => 'Health & Fitness', 'parent_id' => null,]);
         Category::create(['name' => 'Music', 'parent_id' => null,]);
         Category::create(['name' => 'Teaching & Academic', 'parent_id' => null,]);



        Category::create(['name' => 'Web Development', 'parent_id' => 1]);
        Category::create(['name' => 'Data Science', 'parent_id' => 1]);
        Category::create(['name' => 'Mobile Development', 'parent_id' => 1]);
        Category::create(['name' => 'Programming Languages', 'parent_id' => 1]);
        Category::create(['name' => 'Game Development', 'parent_id' => 1]);
        Category::create(['name' => 'Database Design & Development', 'parent_id' => 1]);
        Category::create(['name' => 'Software Testing', 'parent_id' => 1]);
        Category::create(['name' => 'Software Engineering', 'parent_id' => 1]);
        Category::create(['name' => 'Software Development Tools', 'parent_id' => 1]);
         Category::create(['name' => 'No-Code Development', 'parent_id' => 1]);

        Category::create(['name' => 'Entrepreneurship', 'parent_id' => 2]);
        Category::create(['name' => 'Communication', 'parent_id' => 2]);
        Category::create(['name' => 'Management', 'parent_id' => 2]);
        Category::create(['name' => 'Sales', 'parent_id' => 2]);
        Category::create(['name' => 'Business Strategy', 'parent_id' => 2]);
        Category::create(['name' => 'Operations', 'parent_id' => 2]);
        Category::create(['name' => 'Project Management', 'parent_id' => 2]);
        Category::create(['name' => 'Business Law', 'parent_id' => 2]);
        Category::create(['name' => 'Business Analytics & Intelligence', 'parent_id' => 2]);
         Category::create(['name' => 'Human Resources', 'parent_id' => 2]);
         Category::create(['name' => 'Industry', 'parent_id' => 2]);
         Category::create(['name' => 'E-Commerce', 'parent_id' => 2]);
         Category::create(['name' => 'Media', 'parent_id' => 2]);
         Category::create(['name' => 'Real Estate', 'parent_id' => 2]);

        Category::create(['name' => 'Accounting & Bookkeeping', 'parent_id' => 3]);
        Category::create(['name' => 'Compliance', 'parent_id' => 3]);
        Category::create(['name' => 'Cryptocurrency & Blockchain', 'parent_id' => 3]);
        Category::create(['name' => 'Economics', 'parent_id' => 3]);
        Category::create(['name' => 'Finance Strategy', 'parent_id' => 3]);
        Category::create(['name' => 'Finance Cert & Exam Prep ', 'parent_id' => 3]);
        Category::create(['name' => 'Financial Modeling & Analysis', 'parent_id' => 3]);
        Category::create(['name' => 'Investing & Trading', 'parent_id' => 3]);
        Category::create(['name' => 'Money Management Tools', 'parent_id' => 3]);
         Category::create(['name' => 'Taxes', 'parent_id' => 3]);

        Category::create(['name' => 'IT Certifications', 'parent_id' => 4]);
        Category::create(['name' => 'Network & Security', 'parent_id' => 4]);
        Category::create(['name' => 'Hardware', 'parent_id' => 4]);
        Category::create(['name' => 'Operating Systems & Servers', 'parent_id' => 4]);
        Category::create(['name' => 'Other IT & Software', 'parent_id' => 4]);


        Category::create(['name' => 'Microsoft', 'parent_id' => 5]);
        Category::create(['name' => 'Apple', 'parent_id' => 5]);
        Category::create(['name' => 'Google', 'parent_id' => 5]);
        Category::create(['name' => 'SAP & Servers', 'parent_id' => 5]);
        Category::create(['name' => 'Oracle', 'parent_id' => 5]);
        Category::create(['name' => 'Other Office Productivity', 'parent_id' => 5]);


        Category::create(['name' => 'Personal Transformation', 'parent_id' => 6]);
        Category::create(['name' => 'Personal Productivity', 'parent_id' => 6]);
        Category::create(['name' => 'Leadership', 'parent_id' => 6]);
        Category::create(['name' => 'Career Development', 'parent_id' => 6]);
        Category::create(['name' => 'Parenting & Relationships', 'parent_id' => 6]);
        Category::create(['name' => 'Happiness', 'parent_id' => 6]);
        Category::create(['name' => 'Esoteric Practices', 'parent_id' => 6]);
        Category::create(['name' => 'Religion & Spirituality', 'parent_id' => 6]);
        Category::create(['name' => 'Personal Brand Building', 'parent_id' => 6]);
         Category::create(['name' => 'Creativity', 'parent_id' => 6]);
         Category::create(['name' => 'Influence', 'parent_id' => 6]);
         Category::create(['name' => 'Self Esteem & Confidence', 'parent_id' => 6]);
         Category::create(['name' => 'Stress Management', 'parent_id' => 6]);
         Category::create(['name' => 'Memory & Study Skills', 'parent_id' => 6]);
         Category::create(['name' => 'Motivation', 'parent_id' => 6]);


        Category::create(['name' => 'Web Design', 'parent_id' => 7]);
        Category::create(['name' => 'Graphic Design & Illustration', 'parent_id' => 7]);
        Category::create(['name' => 'Design Tools', 'parent_id' => 7]);
        Category::create(['name' => 'User Experience Design', 'parent_id' => 7]);
        Category::create(['name' => 'Game Design & Relationships', 'parent_id' => 7]);
        Category::create(['name' => '3D & Animation', 'parent_id' => 7]);
        Category::create(['name' => 'Fashion Design', 'parent_id' => 7]);
        Category::create(['name' => 'Architectural Design', 'parent_id' => 7]);
        Category::create(['name' => 'Interior Design', 'parent_id' => 7]);


        Category::create(['name' => 'Digital Marketing', 'parent_id' => 8,]);
        Category::create(['name' => 'Search Engine Optimization', 'parent_id' => 8]);
        Category::create(['name' => 'Social Media Marketing', 'parent_id' => 8]);
        Category::create(['name' => 'Branding', 'parent_id' => 8]);
        Category::create(['name' => 'Marketing Fundamentals', 'parent_id' => 8]);
        Category::create(['name' => 'Marketing Analytics & Automation', 'parent_id' => 8]);
        Category::create(['name' => 'Public Relations', 'parent_id' => 8]);
        Category::create(['name' => 'Paid Advertising', 'parent_id' => 8]);
        Category::create(['name' => 'Video & Mobile Marketing', 'parent_id' => 8]);
        Category::create(['name' => 'Content Marketing', 'parent_id' => 8]);
         Category::create(['name' => 'Growth Hacking', 'parent_id' => 8]);
         Category::create(['name' => 'Affiliate Marketing', 'parent_id' => 8]);
         Category::create(['name' => 'Product Marketing', 'parent_id' => 8]);
         Category::create(['name' => 'Other Marketing', 'parent_id' => 8]);


        Category::create(['name' => 'Arts & Crafts', 'parent_id' => 9]);
        Category::create(['name' => 'Beauty & Makeup', 'parent_id' => 9]);
        Category::create(['name' => 'Esoteric Practices', 'parent_id' => 9]);
        Category::create(['name' => 'Food & Beverage', 'parent_id' => 9]);
        Category::create(['name' => 'Gaming', 'parent_id' => 9]);
        Category::create(['name' => 'Home Improvement & Gardening', 'parent_id' => 9]);
        Category::create(['name' => 'Pet Care & Training', 'parent_id' => 9]);
        Category::create(['name' => 'Travel', 'parent_id' => 9]);
        Category::create(['name' => 'Other Lifestyle', 'parent_id' => 9]);


         Category::create(['name' => 'Digital Photography', 'parent_id' => 10]);
         Category::create(['name' => 'Photography', 'parent_id' => 10]);
         Category::create(['name' => 'Portrait Photography', 'parent_id' => 10]);
         Category::create(['name' => 'Photography Tools', 'parent_id' => 10]);
         Category::create(['name' => 'Commercial Photography', 'parent_id' => 10]);
         Category::create(['name' => 'Video Design', 'parent_id' => 10]);
         Category::create(['name' => 'Other Photography & Video', 'parent_id' => 10]);


         Category::create(['name' => 'Fitness', 'parent_id' => 11]);
         Category::create(['name' => 'General Health', 'parent_id' => 11]);
         Category::create(['name' => 'Sports', 'parent_id' => 11]);
         Category::create(['name' => 'Nutrition & Diet', 'parent_id' => 11]);
         Category::create(['name' => 'Yoga', 'parent_id' => 11]);
         Category::create(['name' => 'Mental Health', 'parent_id' => 11]);
         Category::create(['name' => 'Martial Arts & Self Defense', 'parent_id' => 11]);
         Category::create(['name' => 'Safety & First Aid', 'parent_id' => 11]);
         Category::create(['name' => 'Meditation', 'parent_id' => 11]);


         Category::create(['name' => 'Instruments', 'parent_id' => 12]);
         Category::create(['name' => 'Music Production', 'parent_id' => 12]);
         Category::create(['name' => 'Music Fundamentals', 'parent_id' => 12]);
         Category::create(['name' => 'Vocal', 'parent_id' => 12]);
         Category::create(['name' => 'Music Techniques', 'parent_id' => 12]);
         Category::create(['name' => 'Music Software', 'parent_id' => 12]);

         Category::create(['name' => 'Engineering', 'parent_id' => 13]);
         Category::create(['name' => 'Humanities', 'parent_id' => 13]);
         Category::create(['name' => 'Math', 'parent_id' => 13]);
         Category::create(['name' => 'Science', 'parent_id' => 13]);
         Category::create(['name' => 'Online Education', 'parent_id' => 13]);
         Category::create(['name' => 'Social Science', 'parent_id' => 13]);
         Category::create(['name' => 'Language Learning', 'parent_id' => 13]);
         Category::create(['name' => 'Teacher Training', 'parent_id' => 13]);
         Category::create(['name' => 'Test Prep', 'parent_id' => 13]);



















    }
}
