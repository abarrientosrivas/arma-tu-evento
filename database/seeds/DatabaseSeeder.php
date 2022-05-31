<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Log;
use App\Post;
use App\Evento;
use App\Proveedor;
use App\Certificado;
use App\Rubro;
use App\Denuncia;
use App\Cliente;
use App\Admin;
use App\Notificacion;
use App\Conversation;
use App\TipoPago;


class DatabaseSeeder extends Seeder
{

    private $rubros = ['Multirubro', 'DJ','Catering', 'Decoración', 'Animación', 'Barra de tragos', 'Pastelería', 
                        'Audio', 'Seguridad', 'Fotografía', 'Salones', 'Mesa dulce', 'Iluminación',
                        'Vestuario', 'Filmación', 'Peluquería', 'Maquillaje'];
    private $tipos = ['Publicación destacada','Rubro destacado','Mensual','Trimestral','Anual'];
    
    // private $certificados = [
    //     ['titulo' => 'Manipulación de alimentos', 'rubro_id' => 3, 'obligatorio' => true],
    //     ['titulo' => 'Habilitación municipal', 'rubro_id' => 11, 'obligatorio' => true],
    //     ['titulo' => 'Habilitación prestadora de servicios de seguridad', 'rubro_id' => 9, 'obligatorio' => true],
    //     ['titulo' => 'Certifficado AADI', 'rubro_id' => 2, 'obligatorio' => true],
    //     ['titulo' => 'Certificado CAPIF', 'rubro_id' => 8, 'obligatorio' => true],
    //     ['titulo' => 'Registro de proveedores', 'rubro_id' => 1, 'obligatorio' => true]
    // ];

    

    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        

        // Seed table Rubros first

        foreach ($this->rubros as $rubro) {
            Rubro::firstOrCreate([
                'nombre' => $rubro,
                'rubroImage' => $rubro . '.jpg'
                ]);
        }

        // Create tipos de pago
        foreach ($this->tipos as $tipo) {
          TipoPago::firstOrCreate([
            'periodo' => $tipo,
            'precio' => rand(100,950)
          ]);
        }

        // Admin::firstOrCreate([
        //     'email' => 'alexis@armatuevento.com',
        //     'password' => Hash::make('alexis')
        // ]);
        
        // Admin::firstOrCreate([
        //     'email' => 'matias@armatuevento.com',
        //     'password' => Hash::make('matias')
        // ]);

        // Create 10 records of proveedor
        factory(App\Proveedor::class, 20)->create()->each(function($proveedor){
            // Seed the relation with 5 posts
            $posts = factory(App\Post::class, rand(0,4))->make();
            // $certificados = factory(App\Certificado::class, rand(0,8))->make();

            $proveedor->posts()->saveMany($posts);
            // $proveedor->certificados()->saveMany($certificados);
        });

        // factory(App\Certificado::class, rand(10,20))->create();
        // Create around 50 records of clientes
        factory(App\Cliente::class, 10)->create()->each(function($cliente){
          // Seed the realtion with 0 to 3 eventos
          $eventos = factory(App\Evento::class, rand(0,3))->make();
          // Seed the realtion with 0 to 3 reseñas
          $resenas = factory(App\Resena::class, rand(0,2))->make([
            'post_id' => Post::inRandomOrder()->first(),
          ]);
          // Seed the realtion with 0 to 3 denuncias
          $denuncias = factory(App\Denuncia::class, rand(0,2))->make([
            'post_id' => Post::inRandomOrder()->first(),
          ]);

          $cliente->eventos()->saveMany($eventos);
          $cliente->resenas()->saveMany($resenas);
          $cliente->denuncias()->saveMany($denuncias);
        });

        factory(App\Notificacion::class, 10)->create();

        // Seed posts with reseñas
        // Post::all()->each(function($post){
            // Seed the relation with 0 to 8 reseñas
            // $resenas = factory(App\Resena::class, rand(0,8))->make([
            //   'cliente_id' => rand(1,30),
            // ]);

            // $resenas = factory(App\Resena::class, rand(0,8))->make();

            // $post->resenas()->saveMany($resenas);
            // App\Cliente::all()->each(function($cliente){
            //   $cliente->resenas()->saveMany($resenas);
            // });

        // });

        // App\Cliente::all()->each(function($cliente){
        //   $resenas = factory(App\Resena::class, rand(0,8))->make();
        //
        //   $cliente->resenas()->saveMany($resenas);
        // });

        // Seed manyToMany relation between evento-post
        Evento::all()->each(function($evento){
            for($i = 0; $i <= rand(3,8); $i++){
                $post = Post::inRandomOrder()->first();
                if ($post->maxPersonas >= $evento->cantPersonas) { $evento->posts()->save($post); }
            }
        });

        Proveedor::all()->each(function($proveedor){
            for($i = 0; $i <= rand(0,2); $i++){
                $cliente = Cliente::inRandomOrder()->first();
                $conversation = new Conversation;
                $conversation->cliente_id = $cliente->id;
                $conversation->proveedor_id = $proveedor->id;
                $conversation->save();
            }
        });

        Conversation::with('proveedor')->with('cliente')->get()->each(function($conversation){
            for($i = 0; $i <= rand(1,4); $i++){
                $message = factory(App\Message::class)->make();
                if (rand(0, 1)) { $message->senderName = $conversation->proveedor->nombre; }
                else { $message->senderName = $conversation->cliente->nombre . ' ' . $conversation->cliente->apellido; }
                $conversation->messages()->save($message);
            }
        });

        // $this->call(CertificadosTableSeeder::class);
        // Certificado::insert($this->certificados);
        // Proveedor::insert($this->proveedores);
        // private $proveedores = [
        //     ['nombre'=>'Pasteleria Alta Torta', 'rubro_id'=>7, 'descripcion'=>'Las mejores tortas de la zona', 'cuit'=>'+1-434-436-4743', 'email'=>'altatorta@tortas.com', 'password'=>'tortas', 'profileImage'=>'torta.jpg']
        // ];
        DB::table('proveedors')
            ->where('id',1)
            ->update([
                'descripcion'=>'Las mejores tortas de la zona',
                'email'=>'altatorta@tortas.com',
                'nombre'=>'Pasteleria Alta Torta',
                'profileImage'=>'torta.jpg',
                'rubro_id'=>7,
            ]); 
        DB::table('proveedors')
            ->where('id',2)
            ->update([
                'descripcion'=>'Tengo un usb de 8gb y en la compu un montón de música',
                'email'=>'elsebas999@hotmail.com',
                'nombre'=>'DJ Seba',
                'profileImage'=>'djseba.jpg',
                'rubro_id'=>2,
            ]);
        DB::table('proveedors')
            ->where('id',3)
            ->update([
                'descripcion'=>'Saco fotos panorámicas, con filtros de insta, con un dron, con go pro, con lo que sea',
                'email'=>'fotosmadryn@gmail.com',
                'nombre'=>'Fotografiador Pro',
                'profileImage'=>'fotografiante.jpg',
                'rubro_id'=>10,
            ]);
        DB::table('proveedors')
            ->where('id',4)
            ->update([
                'descripcion'=>'Todos los guardias tienen pinta de que han visto demasiado',
                'email'=>'seguridad@gmail.com',
                'nombre'=>'Indestructibles',
                'profileImage'=>'indestructibles.jpg',
                'rubro_id'=>9,
            ]);
        DB::table('proveedors')
            ->where('id',5)
            ->update([
                'descripcion'=>'Una vez rompi los vidrios de mi cuarto escuchando rocanrol y desde entonces me encantan los sistemas de audio',
                'email'=>'bassboosted@gmail.com',
                'nombre'=>'Bass Boosted',
                'profileImage'=>'audio.jpg',
                'rubro_id'=>8,
            ]);
        DB::table('proveedors')
            ->where('id',6)
            ->update([
                'descripcion'=>'Mi personaje favorito de DC es piñon fijo',
                'email'=>'joker@gmail.com',
                'nombre'=>'Maquillajes Piñón Fijo',
                'profileImage'=>'maquillaje.jpg',
                'rubro_id'=>17,
            ]);
        DB::table('proveedors')
            ->where('id',7)
            ->update([
                'descripcion'=>'Mi salón está re piola',
                'email'=>'gransalon@gmail.com',
                'nombre'=>'El papá de los salones',
                'profileImage'=>'salones.jpg',
                'rubro_id'=>11,
            ]);

        // 5 clientes mas
    }
}
