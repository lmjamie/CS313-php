<?php
  class Item {
    function Item($name, $short_des, $long_des, $content, $price, $quantity, $img_path, $discount = 0, $img_alt = "Item Image") {
      $this->name = $name;
      $this->short_des = $short_des;
      $this->long_des = $long_des;
      $this->content = $content;
      $this->price = $price;
      $this->quantity = $quantity;
      $this->img_path = $img_path;
      $this->discount = $discount;
      $this->img_alt = $img_alt;
    }

    function sell($qty) {
      $this->quantity = max($this->quantity - $qty, 0);
    }

    function get_name() {
      return $this->name;
    }

    function calc_discount($qty) {
    return ($this->price * (1.0 - $this->discount)) * $qty;
  }

    function discount_display() {
      return "$" . $this->price_discounted();
    }

    function price_discounted ($qty = 1) {
      return number_format($this->calc_discount($qty), 2);
    }

    function card_display() {
      echo
      "<div class=\"card z-depth-5\">
        <div class=\"card-image\">
          <img src=\"$this->img_path\" alt=\"$this->img_alt\"/>
        </div>
        <div class=\"card-content blue-grey darken-4\">
          <span class=\"card-title green-text text-lighten-3\">$this->name</span>
          <p class=\"green-text text-lighten-5\">$this->short_des</p>
          <span class=\"" . ($this->quantity > 0 ?
            "green-text\">" . ($this->discount > 0 ?
            ($this->discount * 100) . "% Off!" : "Regular Price") : "red-text\"> Out of Stock") . "</span>
        </div>
        <div class=\"card-action blue-grey darken-3\">
          <button type=\"button\" onclick=\"set_page(this)\" value=\"$this->name\"
                  class=\"waves-effect waves-purple btn green green-text text-lighten-5 tooltipped\"
                  data-position=\"bottom\" data-delay=\"1000\" data-tooltip=\"See Item Details!\">
             <i class=\"material-icons right\">shopping_cart</i>" . $this->discount_display() . "</button>
        </div>
      </div>";
  }

  function detail_display() {
    global $page;
    $page = "item_detail";
    echo
       "<div class=\"container center\">
         <div class=\"row\">";
    require("php/titles.php");
    echo
    "</div>
    <div class=\"row\">";
    require("php/image.php");
    make_image($this->img_path, $this->img_alt, 6);
    echo
    "<div class=\"col l6 m12\">
        <blockquote>$this->long_des</blockquote>
      </div>
    </div>
      <div class=\"row\">
        <div class=\"col l6 m12 \">
          <ul class=\"collection with-header\">
            <li class=\"collection-header green lighten-1 blue-grey-text text-lighten-5\"><h4>Contents</h4></li>";
    foreach ($this->content as $c) {
      echo "<li class=\"collection-item green lighten-1 blue-grey-text text-lighten-5\">$c</li>";
    }
    echo "</ul>
        </div>
        <div class=\"col l6 m12\">
          <div class=\"card blue-grey-text text-lighten-5\">
            <div class=\"card-panel green\">" .
              ($this->quantity != 0 ?
              ($this->discount > 0 ? "<span>Discounted " .   ($this->discount * 100) . "%</span>" : "") .
              "<p>Price: " . $this->discount_display() . "</p>
              <p>Quantity Available: $this->quantity</p>" :
              "<p>Out of Stock!</p>") .
            "<button type=\"button\" onclick=\"add_to_cart(this)\" value=\"$this->name\"
                     class=\"waves-effect waves-purple btn green green-text lighten-5 tooltipped" . ($this->quantity != 0 ? "" : " disabled") . "\"
                     data-position=\"bottom\" data-delay=\"1000\" data-tooltip=\"Click to add the quantity selected to your cart!\">
               <i class=\"material-icons right\">shopping_cart</i>Add to Cart</button>
               <a class='dropdown-button btn green green-text lighten-5' href='#'
                  value=\"1\" data-activates='quantity_list'><i class=\"material-icons left\">expand_more</i>1</a>
        <ul id='quantity_list' class='dropdown-content' value=\"$this->quantity\">";
        for ($i=1; $i <= $this->quantity; ++$i) {
          echo "<li><a href=\"javascript:void(0)\" class=\"green green-text lighten-5\" onclick=\"update_quantity(this.innerHTML)\">$i</a></li>
       <li class=\"divider\"></li>";
        }
    echo
          "</ul>
            </div>
          </div>
        </div>
        </div>
      </div>
    </div>";
  }

  function cart_display($qty, $id) {
    echo "<img src=\"$this->img_path\" alt=\"$this->img_alt\" class=\"circle\">
      <span class=\"title\">$this->name</span><br>
      <p>Qty: $qty<br>
        Total: $" . $this->price_discounted($qty) .
        "</p>
        <a href=\"#!\" id=\"$id\" onclick=\"edit_cart($('#$id'), 0)\" value=\"$this->name\" class=\"secondary-content green-text text-lighten-5\"><i class=\"material-icons\">clear</i></a>";
  }
}
?>
