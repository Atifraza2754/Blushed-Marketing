<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // \App\Models\User::factory(10)->create();

        $this->call(SiteSettingsTableSeeder::class);
        $this->call(NotificationsTableSeeder::class);
        
        $this->call(CountriesTableSeeder::class);
        $this->call(RolesTableSeeder::class);
        $this->call(UsersTableSeeder::class);
        $this->call(InvitesTableSeeder::class);
        $this->call(TrainingsTableSeeder::class);
        $this->call(UsersTrainingsTableSeeder::class);
        $this->call(InfosTableSeeder::class);

        $this->call(QuizzesTableSeeder::class);
        $this->call(QuizQuestionsTableSeeder::class);
        $this->call(QuizQuestionOptionsTableSeeder::class);
        $this->call(UserQuizzesTableSeeder::class);

        $this->call(RecapsTableSeeder::class);
        $this->call(RecapQuestionsTableSeeder::class);
        $this->call(RecapQuestionOptionsTableSeeder::class);
        $this->call(UserRecapsTableSeeder::class);
        $this->call(UserRecapQuestionsTableSeeder::class);

        $this->call(W9formsTableSeeder::class);
        $this->call(PayrollsTableSeeder::class);
        $this->call(MessagesTableSeeder::class);
    }
}
