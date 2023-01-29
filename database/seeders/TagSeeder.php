<?php

namespace Database\Seeders;

use App\Models\Tag;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class TagSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Tag::create(['name' => 'HTML', 'category_id' => 14]);
        Tag::create(['name' => 'CSS', 'category_id' => 14]);
        Tag::create(['name' => 'JavaScript', 'category_id' => 14]);
        Tag::create(['name' => 'Responsive Design', 'category_id' => 14]);
        Tag::create(['name' => 'Front-End Development', 'category_id' => 14]);
        Tag::create(['name' => 'Back-End Development', 'category_id' => 14]);
        Tag::create(['name' => 'Web Design', 'category_id' => 14]);

        Tag::create(['name' => 'Data Analysis', 'category_id' => 15]);
        Tag::create(['name' => 'Data Visualization', 'category_id' => 15]);
        Tag::create(['name' => 'Data Mining', 'category_id' => 15]);
        Tag::create(['name' => 'Big Data', 'category_id' => 15]);
        Tag::create(['name' => 'Machine Learning', 'category_id' => 15]);
        Tag::create(['name' => 'Data Management', 'category_id' => 15]);

        Tag::create(['name' => 'iOS Development', 'category_id' => 16]);
        Tag::create(['name' => 'Android Development', 'category_id' => 16]);
        Tag::create(['name' => 'Swift/Objective-C (iOS)', 'category_id' => 16]);
        Tag::create(['name' => 'Java/Kotlin (Android)', 'category_id' => 16]);
        Tag::create(['name' => 'React Native', 'category_id' => 16]);
        Tag::create(['name' => 'Ionic', 'category_id' => 16]);
        Tag::create(['name' => 'Flutter', 'category_id' => 16]);
        Tag::create(['name' => 'Mobile Design', 'category_id' => 16]);

        Tag::create(['name' => 'Java', 'category_id' => 17]);
        Tag::create(['name' => 'Python', 'category_id' => 17]);
        Tag::create(['name' => 'JavaScript', 'category_id' => 17]);
        Tag::create(['name' => 'C++', 'category_id' => 17]);
        Tag::create(['name' => 'C#', 'category_id' => 17]);
        Tag::create(['name' => 'PHP', 'category_id' => 17]);
        Tag::create(['name' => 'Ruby', 'category_id' => 17]);
        Tag::create(['name' => 'Go', 'category_id' => 17]);
        Tag::create(['name' => 'Swift', 'category_id' => 17]);
        Tag::create(['name' => 'Rust', 'category_id' => 17]);

        Tag::create(['name' => 'Unity', 'category_id' => 18]);
        Tag::create(['name' => 'Unreal Engine', 'category_id' => 18]);
        Tag::create(['name' => 'Game Development Tools', 'category_id' => 18]);
        Tag::create(['name' => 'Multiplayer Game Development', 'category_id' => 18]);


        Tag::create(['name' => 'SQL', 'category_id' => 19]);
        Tag::create(['name' => 'NoSQL', 'category_id' => 19]);
        Tag::create(['name' => 'Data Modeling', 'category_id' => 19]);
        Tag::create(['name' => 'Database Administration', 'category_id' => 19]);
        Tag::create(['name' => 'Object-Relational Mapping (ORM)', 'category_id' => 19]);
        Tag::create(['name' => 'Indexing and Query Optimization', 'category_id' => 19]);
        Tag::create(['name' => 'Database Security', 'category_id' => 19]);

        Tag::create(['name' => 'Test Automation', 'category_id' => 20]);
        Tag::create(['name' => 'Unit Testing', 'category_id' => 20]);
        Tag::create(['name' => 'Security Testing', 'category_id' => 20]);
        Tag::create(['name' => 'Test-Driven Development (TDD)', 'category_id' => 20]);
        Tag::create(['name' => 'Continuous Integration and Testing (CI/CT)', 'category_id' => 20]);
        Tag::create(['name' => 'Functional Testing', 'category_id' => 20]);

        Tag::create(['name' => 'Design Patterns', 'category_id' => 21]);
        Tag::create(['name' => 'Software Architecture', 'category_id' => 21]);
        Tag::create(['name' => 'Software Development Methodologies', 'category_id' => 21]);
        Tag::create(['name' => 'Software Project Management', 'category_id' => 21]);
        Tag::create(['name' => 'Software Quality Assurance', 'category_id' => 21]);
        Tag::create(['name' => 'Software Development Best Practices', 'category_id' => 21]);

    }
}
