<?php

namespace App\Repositories;

use App\Models\Kategori;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class KategoriRepositories extends Repository {

    protected $kategori;
    public function __construct(Kategori $kategori)
    {
        $this->kategori = $kategori;
    }

    public function search(Request $request)
    {
        $kategori = $this->kategori->orderBy('kode', 'asc');

        $paginate = $request->input('paginate') ?? null;
        if ($paginate != null) return $kategori->paginate($paginate);
        return $kategori->get();
    }

    public function find($value, $column = 'id')
    {
        return $this->kategori->where($column, $value)->first();
    }

    public function save(Request $request)
    {
        $kategori = $this->kategori->find($request->input('id'));
        if (empty($kategori)) $kategori = $this->kategori->create($request->all());
        else $kategori->update($request->all());
        return $kategori;
    }

    public function delete($id)
    {
        $kategori = $this->kategori->find($id);
        if (!empty($kategori)) $kategori->delete();
        return $kategori;
    }

    protected $skip = array();
    public function nested_data($data, $parent_kode = '#')
    {
        $result = array();
        foreach ($data as $item) {
            if (!in_array($item->id, $this->skip) && $item->parent_kode == $parent_kode) {
                array_push($this->skip, $item->id);
                $item->children = $this->nested_data($data, $item->kode);
                array_push($result, $item);
            }
        }
        return $result;
    }

    public function kode($parent_kode)
    {
        return $this->auto_kode($this->kategori, $parent_kode);
    }

    public function reposisi(Request $request, $jarak = 1)
    {
        $fitur = $this->kategori->find($request->input('id'));
        $kode_asal = $fitur->kode;
        $kode_array = explode(".", $fitur->kode);
        $kode = $kode_array[count($kode_array)-1];
        $kode_tujuan = $request->input('arah') == 'up' ? intval($kode) - $jarak : intval($kode) + $jarak;
        if (strlen($kode_tujuan) == 1) $kode_tujuan = '0' . $kode_tujuan;
        if ($fitur->parent_kode != '#') $kode_tujuan = $fitur->parent_kode. '.' .$kode_tujuan;
        $fitur_tujuan = $this->kategori->where('kode', '=', $kode_tujuan)->first();

        if (!empty($fitur_tujuan)) {
            $temp_kode = mt_rand(111,999);

            //=====tujuan pindah ke temp
            $this->swap_kode($kode_tujuan, $temp_kode);

            //=====asal pindah ke tujuan
            $this->swap_kode($kode_asal, $kode_tujuan);

            //=====temp pindah ke asal
            $this->swap_kode($temp_kode, $kode_asal);
        } else {
            $this->reposisi($request, $jarak+1);
        }
        return $fitur;
    }

    public function swap_kode($kode_asal, $kode_tujuan)
    {
        $this->kategori->where('kode', "$kode_asal")->update(['kode' => "$kode_tujuan"]);
        if ($this->kategori->where('parent_kode', "$kode_asal")->count() > 0)
            $this->kategori->where('parent_kode', "$kode_asal")
                ->update([
                    'kode' => DB::raw("replace(kode, parent_kode, '". (string) $kode_tujuan ."')"),
                    'parent_kode' => "$kode_tujuan"
                ]);
    }

    public function dropdown($slug = false)
    {
        $result = array();
        $projects = $this->kategori->orderBy('kode')->get();
        foreach ($projects as $project) $result[$slug = true ? $project->slug : $project->id] = $project->nama;
        return $result;
    }

}
