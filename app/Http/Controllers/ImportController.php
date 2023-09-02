<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Imports\ProductsImport;

class ImportController extends Controller
{
  public function store(Request $request)
  {               
    $file = $request->file('file')->store('import');        
    $import = new ProductsImport;
    $import->import($file);
    return back()->withStatus('Import in queue, we will send notification after import finished.');
    return $request->all();   
  }
}
