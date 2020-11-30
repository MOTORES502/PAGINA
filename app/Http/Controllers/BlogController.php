<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class BlogController extends Controller
{
    public function index(Request $request)
    {
        $title = 'Blog';
        $description = 'Blog informativo relacionado a los vehículos.';
        $keywords = array();
        $image = asset('img/logo_s_fondo_mrm.png');

        $this->seo($title, $description, $keywords, null, $image, 'website');

        $data = DB::connection('mysql')->table('blog')
        ->join('users', 'blog.users_id', 'users.id')
        ->join('people', 'users.people_id', 'people.id')
        ->select(
            'blog.id AS id',
            'blog.image AS image',
            'blog.name AS name',
            'blog.description AS description',
            'blog.created_at AS created_at',
            DB::RAW('REPLACE(LOWER(blog.name)," ","_") AS slug'),
            DB::RAW('CONCAT(people.names," ",people.surnames) AS usuario')
        )
        ->whereNull('blog.deleted_at')->paginate(8);

        if ($request->ajax()) {
            return response()->json(view('paginado.blog', compact('data'))->render());
        }

        return view('blog', compact('data'));
    }

    public function seleccionado($slug, $value)
    {
        $title = 'Blog';
        $description = str_replace('_', ' ', $slug);
        $keywords = array();
        $image = asset('img/logo_s_fondo_mrm.png');

        $this->seo($title, $description, $keywords, null, $image, 'website');

        $blog = DB::connection('mysql')->table('blog')
        ->join('users', 'blog.users_id', 'users.id')
        ->join('people', 'users.people_id', 'people.id')
        ->select(
            'blog.id AS id',
            'blog.image AS image',
            'blog.name AS name',
            'blog.description AS description',
            'blog.created_at AS created_at',
            'users.photo AS usuario_foto',
            DB::RAW('CONCAT(people.names," ",people.surnames) AS usuario')
        )
        ->where('blog.id', base64_decode($value))
        ->whereNull('blog.deleted_at')
        ->first();

        $publicaciones = DB::connection('mysql')->table('blog')
        ->join('users', 'blog.users_id', 'users.id')
        ->join('people', 'users.people_id', 'people.id')
        ->select(
            'blog.id AS id',
            'blog.image AS image',
            'blog.name AS name',
            DB::RAW('REPLACE(LOWER(blog.name)," ","_") AS slug'),
            DB::RAW('CONCAT(people.names," ",people.surnames) AS usuario')
        )
        ->where('blog.id', '!=', base64_decode($value))
        ->whereNull('blog.deleted_at')
        ->limit(4)
        ->get();


        return view('blog_single', compact('blog', 'publicaciones'));
    }
}
