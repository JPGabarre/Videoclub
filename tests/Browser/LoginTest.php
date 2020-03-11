<?php

namespace Tests\Browser;

use Illuminate\Foundation\Testing\DatabaseMigrations;
use Laravel\Dusk\Browser;
use Tests\DuskTestCase;

class LoginTest extends DuskTestCase
{
    /**
     * A Dusk test example.
     *
     * @return void
     */
    public function testExample()
    {
        $this->browse(function (Browser $browser) {
                //Login
            $browser->visit('/videoclub/login')
                ->type('email', 'pepito@gmail.com')
                ->type('password', 'pepito1234')
                ->press('Login')
                ->assertPathIs('/videoclub/catalog')
                ->pause(3000)
                //Buscar pelicula que no existeix
                ->type('q','El cazador de cocodrilos')
                ->pause(2000)
                ->press('BUSCAR')
                ->pause(2000)
                //Buscar pelicula que existeix
                ->type('q','El padrino')
                ->pause(2000)
                ->press('BUSCAR')
                ->pause(2000)
                //Accedir a la informació d'una pelicula
                ->clickLink('El padrino')
                ->assertPathIs('/videoclub/catalog/show/1')
                ->pause(4000);
            $browser->driver->executeScript('window.scrollTo(0, 1000);');

                //Afegir un comentari a aquella pelicula
            $browser->type('title', 'Me ha encantado!')
                ->select('stars', '5 estrella')
                ->type('review', 'No hay palabras para describir bien esta pelicula...')
                ->pause(2000)
                ->press('Valorar')
                ->pause(4000)
                //Crear una pelicula
                ->visit('/videoclub/catalog/create')
                ->assertPathIs('/videoclub/catalog/create')
                ->type('title', 'Salomon Kane')
                ->type('year', '2003')
                ->type('director', 'Johan Cruiff')
                ->select('category_id', 'Drama')
                ->type('poster', 'https://pics.filmaffinity.com/solomon_kane-543897673-large.jpg')
                ->type('synopsis', 'Finals dels anys XVI-ppios del XVII. Historia epica de Vengança')
                ->pause(2000)
                ->press('Añadir película')
                //Anar a veurela al cataleg
                ->assertPathIs('/videoclub/catalog');
            $browser->driver->executeScript('window.scrollTo(0, 1500);');

            $browser->pause(4000)
                //Tancar la sessió
                ->press('Cerrar sesión')
                ->assertPathIs('/videoclub/login')
                ->pause(3000);
        });
    }
}
