<?php

namespace App\Imports;

use App\Models\Product;
use App\Models\SubCategory;
use App\Notifications\ImportHasFailedNotification;
use Illuminate\Support\Collection;
use Illuminate\Support\Str;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Validation\Rule;
use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Concerns\Importable;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Concerns\WithChunkReading;
use Maatwebsite\Excel\Concerns\WithValidation;

class ProductsImport implements ToCollection, WithHeadingRow, WithChunkReading, ShouldQueue, WithValidation
{
  use Importable;

  /**
  * @param Illuminate\Support\Collection $row
  *
  * @return null
  */
  public function collection(Collection $rows)
  {
    foreach ($rows as $row) {
      $plus = explode(',', $row['plu']);
      $plu_forms = explode(',', $row['pluform']);
      $cats = explode(',', $row['cat']);
      $subcats = explode(',', $row['subcat']);
      $brands = explode(',', $row['brand']);
      $promotions = explode(',', $row['promotion']);
      $images = explode(',', $row['image']);
      $forms = explode(',', $row['form']);
      $units = explode(',', $row['unit']);
      $sizes = explode(',', $row['size']);
      $prices = explode(',', $row['price']);
      
      $sizes_len = count($sizes);

      $slug = Str::slug($row['name'], '-');

      $product = Product::create([
        'name' => $row['name'],
        'slug' => $slug,
        'sci_name' => $row['scientific'],
        'other_name' => $row['other'],
        'description' => $row['description'],
        'details' => $row['details'],
        'photo' => $row['photo'],
        'minprice' => $row['minprice']
      ]);

      if($row['pluform']) {
        $i = 0;
        foreach ($plus as $plu) {
          $product->plus()->create([
            'id' => $plu,
            'form_id' => $plu_forms[$i]
          ]);
          $i++;
        }
      } else {
        $product->plus()->create([
          'id' => $plus[0]
        ]);
      }

      if($row['cat'])
        foreach ($cats as $cat)
          $product->cats()->sync($cat, false);

      if($row['subcat'])
        foreach ($subcats as $subcat) {
          $sub = SubCategory::find($subcat);
          $cat = $sub->cat_id;
          $product->cats()->sync($cat, false);
          $product->subcats()->sync($subcat, false);
        }

      if($row['brand'])
        foreach ($brands as $brand)
          $product->brands()->sync($brand, false);

      if($row['promotion'])
        foreach ($promotions as $promotion)
          $product->promotions()->sync($promotion, false);

      if($row['image'])
        foreach ($images as $img) {
          $product->images()->create([
            'name' => $img,
          ]);
        }

      if($row['form']) {
        $i = 0;
        foreach ($forms as $form) {
          $product->forms()->sync($form, false);

          for ($j=0; $j<$sizes_len; $j++) {
            $product->attrs()->create([
              'form_id' => $form,
              'unit' => $units[$j],
              'size' => $sizes[$j],
              'price' => $prices[$j + ($sizes_len * $i)],
            ]);
          }

          $i++;
        }
      } else if ($row['size']) {
        for ($j=0; $j<$sizes_len; $j++) {
          $product->attrs()->create([
            'unit' => $units[$j],
            'size' => $sizes[$j],
            'price' => $prices[$j]
          ]);
        }
        $i++;
      } else {
        $product->attrs()->create([
          'price' => $prices[0]
        ]);
      }
    }
  }

  public function rules(): array
  {
    return [
      '*.id' => ['id', 'unique:product,id']
    ];
  }

  /**
  * Import data in small chunks
  *
  * @return int
  */
  public function chunkSize(): int
  {
    return 500;
  }
}
