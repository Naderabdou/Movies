<?php

namespace App\Console\Commands;

use App\Models\Actor;
use App\Models\Genre;
use App\Models\Movie;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Http;

class GetMovies extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'get:movies';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Get Movies from IMDB';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $this->PopularMovies();
        $this->NowPlayingMovies();
        $this->UpcomingMovies();
        }// end of handle

    private function PopularMovies(): void
    {
        for ($i = 1; $i <=10; $i++) {
            $response = Http::get(config('services.tmdb.base_url') . '/movie/popular', [
                'api_key' => config('services.tmdb.api_key'),
                'region' => 'US',
                'page' => $i,
            ]);
            foreach ($response->json()['results'] as $result) {

                $movie=Movie::updateOrCreate([
                    'e_id' => $result['id'],
                    'title' => $result['title'],
                ],[

                    'description' => $result['overview'],
                    'poster' => $result['poster_path'],
                    'banner' => $result['backdrop_path'],
                    'release_date' => $result['release_date'],
                    'vote' => $result['vote_average'],
                    'vote_count' => $result['vote_count'],
                     'type' => 'popular',
                ]);
                $this->attachGenres($result,$movie);
                $this->attachActors($movie);
                $this->getImages($movie);
            }
        }

    }// end of PopularMovies
    private function NowPlayingMovies(): void
    {
        for ($i = 1; $i <=10;    $i++) {
            $response = Http::get(config('services.tmdb.base_url') . '/movie/now_playing', [
                'api_key' => config('services.tmdb.api_key'),
                'region' => 'US',
                'page' => $i,
            ]);
            foreach ($response->json()['results'] as $result) {

                $movie=Movie::updateOrCreate([
                    'e_id' => $result['id'],
                    'title' => $result['title'],
                ],[

                    'description' => $result['overview'],
                    'poster' => $result['poster_path'],
                    'banner' => $result['backdrop_path'],
                    'release_date' => $result['release_date'],
                    'vote' => $result['vote_average'],
                    'vote_count' => $result['vote_count'],
                    'type' => 'now_playing',
                ]);
                $this->attachGenres($result,$movie);
                $this->attachActors($movie);
                $this->getImages($movie);
            }
        }

    }// end of NowPlayingMovies
    private function UpcomingMovies(): void
    {
        for ($i = 1; $i <= 10; $i++) {
            $response = Http::get(config('services.tmdb.base_url') . '/movie/upcoming', [
                'api_key' => config('services.tmdb.api_key'),
                'region' => 'US',
                'page' => $i,
            ]);
            foreach ($response->json()['results'] as $result) {

                $movie=Movie::updateOrCreate([
                    'e_id' => $result['id'],
                    'title' => $result['title'],
                ],[

                    'description' => $result['overview'],
                    'poster' => $result['poster_path'],
                    'banner' => $result['backdrop_path'],
                    'release_date' => $result['release_date'],
                    'vote' => $result['vote_average'],
                    'vote_count' => $result['vote_count'],
                    'type' => 'upcoming',
                ]);
                $this->attachGenres($result,$movie);
                $this->attachActors($movie);
                $this->getImages($movie);
            }
        }

    }// end of upcomingMovies



    private function attachGenres($result,Movie $movie)
    {

        foreach ($result['genre_ids'] as $genres){

            $genre=Genre::where('e_id',$genres)->first();
            if($genre){
                $movie->genres()->syncWithoutDetaching($genre->id);
            }
        }
    }// end of attachMovies

    private function attachActors(Movie $movie)
    {

      $response = Http::get(config('services.tmdb.base_url') . '/movie/'.$movie['e_id'].'/credits', [
            'api_key' => config('services.tmdb.api_key'),
        ]);
        foreach ($response->json()['cast'] as $index=> $cast){

            if ($cast['known_for_department'] != 'Acting') continue;
            if ($index == 12) break;
            $actor=Actor::where('e_id',$cast['id'])->first();


            if(!$actor){
                $actor=  Actor::create([
                    'e_id' => $cast['id'],
                    'name' => $cast['name'],
                    'image' => $cast['profile_path'],
                ]);
            }// end of if
            $movie->actors()->syncWithoutDetaching($actor->id);
            }// end of for each


    }// end of attachMovies

    private function getImages(Movie $movie){
        $response = Http::get(config('services.tmdb.base_url') . '/movie/'.$movie['e_id'].'/images', [
            'api_key' => config('services.tmdb.api_key'),
        ]);
        //delete old images
        $movie->images()->delete();
        foreach ($response->json()['backdrops'] as $index=> $image){
            if ($index == 4) break;
            $movie->images()->create([
                'image' => $image['file_path'],
            ]);
        }

    }
}
