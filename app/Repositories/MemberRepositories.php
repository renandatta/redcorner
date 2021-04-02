<?php

namespace App\Repositories;

use App\Models\Member;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class MemberRepositories extends Repository {

    protected $member;
    public function __construct(Member $member)
    {
        $this->member = $member;
    }

    public function search(Request $request)
    {
        $member = $this->member;

        $paginate = $request->input('paginate') ?? null;
        if ($paginate != null) return $member->paginate($paginate);
        return $member->get();
    }

    public function find($value, $column = 'id')
    {
        return $this->member->where($column, $value)->first();
    }

    public function save(Request $request)
    {
        $member = $this->member->find($request->input('id'));
        if (empty($member)) $member = $this->member->create($request->all());
        else $member->update($request->all());
        return $member;
    }

    public function delete($id)
    {
        $member = $this->member->find($id);
        if (!empty($member)) $member->delete();
        return $member;
    }

    public function dropdown_jenis_kelamin()
    {
        $result = array();
        foreach (Member::JENIS_KELAMIN as $item) $result[$item] = $item;
        return $result;
    }

}
