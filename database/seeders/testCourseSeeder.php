<?php

namespace Database\Seeders;

use App\Models\Course;
use App\Models\Lecture;
use App\Models\RatingCourse;
use App\Models\Section;
use App\Models\Status;
use App\Models\Subscribe;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class testCourseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $images = ['JEg3rzg7yI0gG5iKE6BdVK0oMsB3J1SUXeAmH7A7.jpg','nodejs.jpg','6WoP2HR40sksSm5LSk2yPy0iPTm8jjuOF3vmig76.png'];
        $videos = ['49xARXUrTZcVl1aCk4Sl9JG5q4U16DJ2KMLI7pws.mp4','Flnt2VJd2CgJUt188PduHXRDwRCwEeX8fUNtUmoK.mp4',
        'fNwOt0unre4alrdhHDNSOz0YH11fey1VubKeWlNS.mp4','GQs28dDPuKEko9UiIktwFjbPmfnjHKPQapVO7rZ3.mp4','nbkPoDNtSJLU54RswsfJmO9VVKCmTfeFuNbHq4El.mp4'];
        $levels = ['All Levels','Beginner','Medium','Advanced'];
        for ($i = 0; $i < 100; $i++) {
            # code...
            $name = fake()->unique()->name();
            $course = Course::create([
                'name' => $name,
                'subtitle' => fake()->text(50),
                'description' => fake()->text(),
                'price' => fake()->numberBetween(0,500),
                'level' => $levels[fake()->numberBetween(0,3)],
                'image' => $images[fake()->numberBetween(0,2)],
                'oranization_id' => '1',
                'category_id' => random_int(14, 135),
                'language_id' => random_int(1, 3),
                'slug' => Str::slug($name),
                'teacher' => 'Ahmed',
                'video' => 'ttt.mp4',
                'requirements' => '"some requirements"',
                'objectives' => '"some objectives"',
                'course_duration' => fake()->numberBetween(3600,100000)
            ]);
            if ($course) {
                RatingCourse::create([
                    'course_id' => $course->id,
                    'range_rate' => random_int(1,5),
                    'numOfRate' => random_int(100,10000),
                ]);
                Subscribe::create([
                    'course_id' => $course->id,
                    'numOfSubscribe' => random_int(100,10000)
                ]);
                Status::create([
                    'course_id' => $course->id,
                    'status' => 'not publish'
                ]);
                for ($k=0; $k < 10; $k++) {
                    $section = Section::create([
                        'name' => fake()->name(),
                        'course_id' => $course->id
                    ]);
                    for ($j=0; $j < 5; $j++) {
                        Lecture::Create([
                            'title' => fake()->text(20),
                            'file_name' => fake()->name(),
                            'lecture_path' => $videos[fake()->numberBetween(0,4)],
                            'type' => 'video',
                            'section_id' =>$section->id,
                            'lecture_duration' => '5:30'
                        ]);
                    }
                }

            }
        }
    }
}
