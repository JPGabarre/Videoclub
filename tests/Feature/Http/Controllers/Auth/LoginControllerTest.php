<?php

namespace Tests\Feature\Http\Controllers\Auth;

use Tests\TestCase;
use App\User;
use App\Movie;

class LoginControllerTest extends TestCase
{ 
    /** @test */ //Login correcte
    public function login_displays_the_login_form(){
        $response = $this->get('login');

        $response->assertStatus(200);
        $response->assertViewIs('auth.login');
    }

    /** @test */ //Login incorrecte
    public function login_displays_validation_errors(){
        $response = $this->post('login', []);

        $response->assertStatus(302);
        $response->assertSessionHasErrors('email');
    }

    /** @test */ //Accedir al llistat de catàleg
    public function catalog_display_validate(){
        $response = $this->get('catalog');

        $response->assertStatus(200);
        $response->assertViewIs('catalog.index');
    }

    /** @test */ //Detall pelicula1
    public function catalog_display_show_FirstMovie(){
        $user = User::find(1);
        $this->actingAs($user);

        $response = $this->get('/catalog/show/1');

        $response->assertStatus(200);
        $response->assertViewIs('catalog.show');
    }

    /** @test */ //Afegir un comentari buit
    public function add_reviewWithOutContent(){
        $this->withoutExceptionHandling();

        $user = User::find(1);
        $this->actingAs($user);

        $response = $this->withoutMiddleware()->post('/review/create',[
            'pelID' => '1',
        ]);

        // retornar que si s'envia sense dades retorna amb errors de sessió
        $response->assertStatus(302);
    }

    /** @test */ //Afegir un comentari amb dades
    public function add_reviewWithContent(){
        
        $this->withoutExceptionHandling();
        
        $user = User::find(1);
        $this->actingAs($user);

        $response = $this->post('/review/create',[
            'title' => 'No tan mal como me esperaba',
            'stars' => '5',
            'review' => 'Al final me ha sorpendido y todo',
            'pelID' => '1',
          ]);

         $this->assertDatabaseHas('reviews',[
            'title' => 'No tan mal como me esperaba'
          ]);
    }

    /** @test */ //Editar una pelicula
    public function editFilm(){
        $this->withoutExceptionHandling();
        $response = $this->withoutMiddleware()->put('/catalog/edit/2', [
            'title' => 'Probando',
            'year' => '1999',
            'director' => 'Quien és?',
            'synopsis' => 'Resumen',
            'category' => 3,
            'trailer' => 'Trailer'
        ]);

        $this->assertDatabaseHas('movies', [
            'title' => 'Probando',
        ]);
    }

    /** @test */ //Crear una pelicula sense dades
    public function add_movieWithoutData(){
        $this->withoutExceptionHandling();

        $response = $this->withoutMiddleware()->post('/catalog/create');
        $response->assertStatus(302);
    }

    /** @test */ //Crear una movie amb la api
    public function add_movieWithApi(){
        $this->withoutExceptionHandling();
        
        $response = $this->withoutMiddleware()->post(route('api.store'), [
            'title' => 'Proba en la API',
            'year' => '1999',
            'director' => 'Quien és?',
            'synopsis' => 'Resumen',
            'category' => 3,
            'trailer' => 'Trailer'
        ]);

        $response->assertStatus(200);
    }

    /** @test */ //Pusa en lloguer una pelicula amb la api
    public function rentMovieWithApi(){
        $response = $this->withoutMiddleware()->put(route('api.rent', ['id' => 1]));
        $response->assertStatus(200);
    }

    /** @test */ //Retornar una pelicula en lloguer amb la api
    public function returnMovieWithApi(){
        $response = $this->withoutMiddleware()->put(route('api.return', ['id' => 1]));
        $response->assertStatus(200);
    }
}
