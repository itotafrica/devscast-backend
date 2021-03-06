<?php

use App\Enumerations\TablesEnum;
use Phinx\Seed\AbstractSeed;

class FillPodcastsTable extends AbstractSeed
{
    /**
     * Run Method.
     *
     * Write your database seeder using this method.
     *
     * More information on writing seeders is available here:
     * http://docs.phinx.org/en/latest/seeding.html
     */
    public function run()
    {
        $faker = \Faker\Factory::create('fr_fR');
        $table = $this->table(TablesEnum::PODCASTS);
        $slugify = new Cocur\Slugify\Slugify();
        $categories = $this->query(
            sprintf("SELECT * FROM %s WHERE 1", TablesEnum::CATEGORIES)
        )->fetchAll(PDO::FETCH_ASSOC);

        for ($i = 0; $i < 20; $i++) {
            $category = $categories[array_rand($categories, 1)];
            $name = $faker->text(40);
            $table->insert([
                'name' => $name,
                'body' => $faker->text(300),
                'duration' => mt_rand(5, 50),
                'thumb_url' => 'https://via.placeholder.com/300/300',
                'audio_url' => 'https://lushitrap.com/assets/artists/bernard-ng/audio/Calm_lushitrapMUSIC.mp3',
                'slug' => $slugify->slugify($name),
                'users_id' => 1,
                'categories_id' => $category['id'],
                'online' => mt_rand(0, 1)
            ]);
        }
        $table->save();
    }
}
