<?php

namespace App\Http\Controllers;

use App\Concerns\HasCrud;
use App\Concerns\HasFile;
use App\Concerns\HasJsonResponse;
use App\Concerns\HasRelations;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Http\Request;

class BaseController extends Controller
{
    use HasFile, HasCrud, HasRelations, HasJsonResponse;

    protected string|Model $model;

    public string|JsonResource|null $resource = null;

    public ?string $orderByColumn = 'created_at';

    public ?string $orderByDirection = 'DESC';
}
