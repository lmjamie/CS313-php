<?php
function random_discount() {
  switch (rand(0 , 14)) {
    case 0: case 1: case 2:
      return 0.0;
    case 3: case 4: case 5:
      return 0.10;
    case 6: case 7: case 8:
      return 0.20;
    case 9: case 10: case 11:
      return 0.25;
    case 12:
      return 0.50;
    case 13:
      return 0.75;
    case 14:
      return 0.90;
  }
}

function random_quantity() {
  switch (rand(0 , 25)) {
    case 0:
      return 0;
    case 1: case 2: case 3:
      return 1;
    case 4: case 5: case 6:
      return 2;
    case 7: case 8: case 9:
      return 3;
    case 10: case 11: case 12:
      return 4;
    case 13: case 14: case 15:
      return 5;
    case 16: case 17: case 19:
      return 6;
    case 20: case 21:
      return 7;
    case 22: case 23:
      return 8;
    case 24:
      return 9;
    case 25:
      return 10;
  }
}

function create_items() {
  $names = array("Amonkhet Booster Pack", "Amonkhet Booster Box", "Amonkhet Bundle", "Planeswalker Decks", "Deck Builder's Toolkit",  "MM 2017 Booster Pack", "MM 2017 Booster Box", "DD: Mind Vs. Might");
  $s_des = array(
    "From the new set Amonkhet, booster packs contain 15 cards to expand your collection!",
     "A box contains 36 booster packs. Great for playing draft with your friends!",
     "A bundle contains 10 packs, a storage container, spin down dice and 80 land.",
     "A 60 card deck containing one of two Planeswalks. Also, contains 2 packs!",
     "Contains 125 semi-randomized cards, 4 packs and 100 lands as well as a storage box.",
     "15 Cards random cards. A premimum foil card in every pack. Lots of valued cards.",
     "24 15-card booster packs fill this premimum box. What great cards will you pull?",
     "Two 60-card decks designed to battle each other. Which will win, mind or might?"
   );
   $l_des = array(
     "For an engaged player, booster packs are the basic unit of Magic. They're used to play Limited formats, like Booster Drafts, as well as to build a collection of cards for use in Constructed formats, like Standard.",
     "It’s a common ritual for engaged players to celebrate a new set by picking up a full booster display—a box of thirty-six booster packs that can be used to play Limited formats, like Booster Drafts and Sealed Deck.",
     "The Amonkhet Bundle lets engaged players dive into the new set, with boosters to help update their decks for the new Standard environment, plus a Player’s Guide complete with a set overview and a visual encyclopedia of every card in the set.",
     "Planeswalker Decks familiarize players who are interested in Magic with basic strategy as well as the setting, characters, and themes of the latest set. Each deck comes with a premium foil Planeswalker card that is likely to appeal to newer and veteran players.",
     "Once a new player understands Magic's basic rules, the Deck Builder's Toolkit jumpstarts their collection and introduces them to deckbuilding.",
     "Modern Masters 2017 Edition takes players back to some of their favorite planes from recent history. Every card in Modern Masters can be added to a Modern format deck, and some cards even feature new artwork.",
     "The set was designed to be drafted. Players can get maximum value out of Modern Masters by designating a portion of their experience for its intended use: to offer a truly epic draft experience.",
     "Duel Decks let players dive right into battle with ready-to-play, sixty-card decks that contain powerful cards united by a theme. <br><br> Will calculated schemes of the mind outwit and prevail? Or will the pure, bold power of might triumph?"
   );
   $contents = array(
     array("15 randomly inserted cards per booster pack of varying rarity"),
     array("36 Booster Packs", "A Buy-A-Box Promo card with alternate art!"),
     array("10 Amonkhet booster packs", "1 Card box", "1 Player's Guide", "80 basic land cards, including 20 full-art basic lands", "25 double-sided tokens", "1 Magic quick reference guide", "1 Spindown life counter"),
     array("1 Ready-to-play 60-card deck, featuring a foil premium Planeswalker card", "2 Amonkhet booster packs", "1 Strategy insert", "1 Magic learn-to-play guide"),
     array("125 semi-randomized cards", "4 fifteen-card booster packs from recent Magic sets", "100 basic land cards, including 25 full-art basic lands", "1 deck builder's guide", "1 Magic quick reference card", "1 full-art reusable card storage box"),
     array("15 randomly inserted cards per booster pack, including 1 premium card in every pack"),
     array("24 Booster Packs"),
     array("2 Ready-to-play, 60-card decks", "2 Deck boxes", "10 creature tokens", "2 Spindown life counters", "Strategy insert", "Rules reference card")
  );
   $prices = array(3.99, 95.00, 42.99, 14.99, 19.99, 9.99, 189.89, 24.99);
   $paths = array("images/store/pack.png", "images/store/box.png", "images/store/bundle.png", "images/store/pwd.png", "images/store/dbtk.png", "images/store/mm17pack.png", "images/store/mmbox.png", "images/store/mvmdd.jpg");
   $alts = array("Pack", "Box", "Bundle", "Planeswalker", "Toolkit", "MM17 Pack", "MM17 Box", "Mind Vs. Might");
   $num_items = count($names);
   for ($i = 0; $i < $num_items; ++$i) {
     $discounts[] = random_discount();
     $counts[] = random_quantity();
     $_SESSION['items_for_sale'][$names[$i]] = new Item($names[$i], $s_des[$i], $l_des[$i], $contents[$i], $prices[$i], $counts[$i], $paths[$i], $discounts[$i], $alts[$i]);
   }
}

  function display_items() {
    if (!isset($_SESSION['items_for_sale'])) {
      create_items();
    }

    foreach ($_SESSION['items_for_sale'] as $item) {
      echo "<div class=\"col l3 m8\">";
      $item->card_display();
      echo "</div>";
    }
  }
 ?>
