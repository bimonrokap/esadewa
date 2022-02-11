<?php
namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Model\AssetVariable;

class AssetController extends Controller
{
    public function file($slug, $id)
    {
        $data = AssetVariable::whereIdAsset($id)->whereVariable($slug)->firstOrFail();

        return response()->download(storage_path("app/" . $data->value));
    }
}
