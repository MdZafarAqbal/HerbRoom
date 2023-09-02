<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Attribute;
use App\Models\Product;
use Auth;
use Illuminate\Http\Request;

class ModalController extends Controller
{
  public function createModal(Request $request) {
    $product = Product::with('attrs', 'forms', 'images')->find($request->product_id);
    
    $forms = $product->forms()->where('status', 'active')->get();
    $images = $product->images()->where('status', 'active')->pluck('name');

    if($forms->isEmpty()) {
      $minprice = $product->attrs()->min('price');
      $maxprice = $product->attrs()->max('price');
      $sizes = $product->attrs()->select('unit', 'size', 'size_detail')->get();
    } else {
      $minprice = $product->attrs()->where('form_id', $forms[0]->id)->min('price');
      $maxprice = $product->attrs()->where('form_id', $forms[0]->id)->max('price');
      $sizes = $product->attrs()->where('form_id', $forms[0]->id)->select('unit', 'size', 'size_detail')->get();
    }

    $minprice = number_format($minprice, 2);
    $maxprice = number_format($maxprice, 2);
    
    $content = "";

    $content .= <<<EOD
      <div id="modal" class="modal">
        <button type="button" class="btn close modal-close" id="close-btn" onclick="closeModal()"><i class="fa-solid fa-xmark"></i></button>
    
        <div class="modal-content">
          <div class="exzoom collapse" id="exzoom">
            <div class="exzoom-img-box">
              <ul class="exzoom-img-ul">
    EOD;

    foreach($images as $img) {
      $content .= <<<EOD
        <li><img src="/images/products$img"></li>
      EOD;
    }

    $content .= <<<EOD
          </ul>
        </div>
        <div class="exzoom-nav"></div>
        <p class="exzoom-btn">
          <a href="javascript:void(0);" class="exzoom-prev-btn"> < </a>
          <a href="javascript:void(0);" class="exzoom-next-btn"> > </a>
        </p>
      </div>

      <div class="modal-details-container">
        <div class="product-modal-detail">
          <h1 id="product-name" class="title product-title">$product->name</h1>

          <div id="modal-form">
    EOD;

    if($forms->isNotEmpty()) {
      $content .= <<<EOD
        <div class="forms modal-radio" id="forms">
          <div id="forms-menu" class="forms-list">
      EOD;
      foreach($forms as $form) {
        if($form == $forms[0]) {
          $content .= <<<EOD
            <input type="radio" id="$form->name" name="product-form" value="$form->id" checked>
            <label for="$form->name">$form->name</label>
          EOD;
        } else {
          $content .= <<<EOD
            <input type="radio" id="$form->name" name="product-form" value="$form->id">
            <label for="$form->name">$form->name</label>
          EOD;
        }
      }

      $content .= <<<EOD
          </div>
        </div>
      EOD;
    }

    $content .= <<<EOD
      <div class="price-size-container modal-radio" id="price-size">
        <div class="prices" id="price">
    EOD;

        
    if($minprice == $maxprice) {
      $content .= <<<EOD
        <strong>AED $minprice</strong>
      EOD;
    } else {
      $content .= <<<EOD
        <strong>AED $minprice - AED $maxprice</strong>
      EOD;
    }

    $content .= <<<EOD
      </div>

      <div id="sizes-menu" class="sizes-list">
    EOD;

    foreach($sizes as $size) {
      $content .= <<<EOD
        <input type="radio" id="$size->size" name="product-size" class="product-size" value="$size->size">
        <label for="$size->size">$size->size $size->unit</label>
      EOD;
    }

    $content .= <<<EOD
                  </div>
                </div>

                <input type="hidden" name="price-input" id="price-input" value="">

                <div class="qty-manage" id="qty-manage">
                  <input type="button" value="-" class="qty-minus minus qty-control" field="quantity" disabled>
                  <input type="number" name="quantity" id="qty" class="qty" min="1" value="1" oninput="this.value = Math.abs(this.value)">
                  <input type="button" value="+" class="qty-plus plus qty-control" field="quantity">
                </div>

                <div class="cart-btn-div" onclick="cartAdd($product->id)">
                  <button id="modal-cart-btn" class="cart-btn">
                    <span class="add-to-cart">Add to Cart</span>
                    <span class="added">Added</span>
                    <i class="fas fa-shopping-cart"></i>
                    <i class="fas fa-box"></i>
                  </button>
                </div>
              </div>
                  
              <a href="/product-detail/$product->slug" class="modal-view-link btn" id="modal-view-link"><i class="fa-solid fa-circle-info" id="product-details-icon"></i>VIEW PRODUCT DETAILS</a>
            </div>
          </div>
        </div>
      </div>
    EOD;

    return $content;
  }

  public function createSizes(Request $request) {
    $attrs = Attribute::where(['product_id' => $request->product_id, 'form_id' => $request->form_id])->get();

    if($attrs->isEmpty()) {
      return;
    } else {
      $minprice = $attrs->min('price');
      $maxprice = $attrs->max('price');
    }

    $minprice = number_format($minprice, 2);
    $maxprice = number_format($maxprice, 2);
    
    $content = "";

    $content .= <<<EOD
      <div class="prices" id="price">
    EOD;

        
    if($minprice == $maxprice) {
      $content .= <<<EOD
        <strong>AED $minprice</strong>
      EOD;
    } else {
      $content .= <<<EOD
        <strong>AED $minprice - AED $maxprice</strong>
      EOD;
    }

    $content .= <<<EOD
      </div>

      <div id="sizes-menu" class="sizes-list">
    EOD;

    foreach($attrs as $attr) {
      $content .= <<<EOD
        <input type="radio" id="$attr->size" name="product-size" class="product-size" value="$attr->size">
        <label for="$attr->size">$attr->size $attr->unit</label>
      EOD;
    }

    $content .= <<<EOD
      </div>
    EOD;

    return $content;
  }
}
