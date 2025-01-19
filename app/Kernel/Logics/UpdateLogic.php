<?php

namespace App\Kernel\Logics;

use Illuminate\Database\Eloquent\Model;
use Throwable;

class UpdateLogic extends StoreLogic
{
//    protected string $identityColumnName = 'updated_by_id';
//
//    public function save($input): Model
//    {
//        if ($this->autoInjectIdentity) {
//            $this->getSessionIdentity($input);
//        }
//
//        $this->model = $this->model->find($input['id']);
//        $this->model->fill($input);
//        $this->model->save();
//
//        return $this->model;
//    }
//
//    protected function returnData(bool $success, $result = [], ?Throwable $exception = null)
//    {
//        if ($success) {
//            return $this->model->where('id', $result->id)
//                ->select($this->selectionColumns())
//                ->first();
//        }
//
//        return $this->errorCode($this->errorCodeBase.'.'.$exception?->getMessage() ?? '', []);
//    }
//
//    protected function selectionColumns(): array|string
//    {
//        return '*';
//    }
}
