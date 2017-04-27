<?php
$info = array(
  'Background' => 'My name is Landon Jamieson. I am born in Edmonton, Alberta,
  Canada. I lived in a small town very north of Edmonton until I was 16 then I
  moved to Idaho Falls.',
  'Mission' => 'I served my mission in the Pennsylvania Pittsburgh Mission. I
  was able to serve from 2011 to 2013. I was able to see a lot of success, help
  many people and see much good done for the people of Pennyslvania.',
  'Beyond the Mission' => 'I worked for a year after my mission. Then in 2014,
  I decided to attend school at Brigham Young University - Idaho. I knew that I
  wanted to study Computer Science since a conversation I had with a missionary
  in Pennsylvania. I have learned C++, Java, Javascript, Elisp, Python and
  others.<br><br>
  I am married to my lovely wife, Sadie. We were married in the Rexburg Temple
  on 17 June 2016. She is from Shelley, Idaho. She is currently Student Teaching
  in Elementary Education and will graduate this July.'
);

foreach ($info as $title => $text) {
  echo
    "<div class=\"col s12\">
      <h5 class=\"header green-text text-lighten-1\">$title</h5>
      <p class=\"flow-text\">
          $text
      </p>
  </div>\n";
}
 ?>
