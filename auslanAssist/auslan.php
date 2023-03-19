
<?php

$card = "";
$auslan_tags = "";
$category_selects = "";
$category_rows = '';
$edit_word_rows = "";

$auslan_types = $conn->query("SELECT * FROM auslan_categories ORDER BY category ASC");
if($auslan_types->num_rows > 0){
  while($row = $auslan_types->fetch_assoc()){

    $category = $row['category'];
    $colour= $row['hex_colour'];
    $category_id = $row['id'];

    $auslan_tags .= '<p style="color:'.$colour.'" data-filter="'.$category.'" class="mx-4 col filtering-tags filter-text2">'.$category.' <i style="color:'.$colour.'" class="bi tag1 bi-tag-fill"></i></p>';

    $category_selects .= '<option value="'.$category_id.'">'.$category.'</option>';

    $category_rows .= '<tr id="cat_row_'.$category_id.'">
      <td><i data-id="'.$category_id.'" class="delete_cat bi bi-trash3"></i></td>
    	<td><input class="edit-words" id="category_input_'.$category_id.'" type="text" value="'.$category.'"/></td>
    	<td><div class="hex_div">
      <span id="hex_text_'.$category_id.'" style="margin-right:10px">'.$colour.'</span>
		    <input type="color" class="colorPickerClass color-block" data-cat_id="'.$category_id.'" value="'.$colour.'" id="colorPicker_'.$category_id.'">
        <br>
        </div>
		</td>
    	<td class="text-center"><button data-id="'.$category_id.'" id="update_cat_'.$category_id.'" class="update_category">Update <i style="margin-left:10px;color: white;" class="fas fa-arrow-right"></i></button></td>
 		 </tr>';

  }
}

$edit_word_rows = "";

$auslan_sql = $conn->query("SELECT a.*, b.* 
FROM auslan AS a INNER JOIN auslan_categories AS b ON b.id = a.category_id ORDER BY a.word ASC");
if($auslan_sql->num_rows > 0){
  while($row = $auslan_sql->fetch_assoc()){
      $id = $row['id'];
      $word = $row['word'];
      $category = $row['category'];
      $cat_id = $row['category_id'];
      $gif = $row['gif'];
      $week = $row['week'];
      $colour = $row['hex_colour'];
      $keywords = $row['keywords'];

      if($keywords == ''){
        $keyword_str = '';
      }else{
        $keyword_str = '<h4 class="card-keywords">'.$keywords.'</h4>';
      }

      $edit_word_selects = '<select style="font-family:Arial, FontAwesome;" class="edit-word-selects" id="select_word_'.$id.'">';

      $edit_word_selects .= '<option selected value="'.$cat_id.'">'.$category.'<i style="color:'.$colour.'" class="bi ml-1 bi-tag-fill"></i></option>';

      $grab_cats = $conn->query("SELECT * FROM auslan_categories WHERE id != ".$cat_id." ORDER BY category ASC");
    if($grab_cats->num_rows > 0){
      while($rowsy = $grab_cats->fetch_assoc()){
    
    $edit_word_selects .= '<option value="'.$rowsy['id'].'">'.$rowsy['category'].'<i style="color:'.$rowsy['hex_colour'].'" class="bi ml-1 bi-tag-fill"></option>';
        }
      }
      $edit_word_selects .= '</select>';


      $edit_word_rows .= '<tr data-id="'.$id.'" class="word_row" id="word_row_'.$id.'">
      <td><i data-word_id="'.$id.'" class="delete_word bi bi-trash3"></i></td>
    	<td style="padding: 10px;">
      
      <div style="display:flex;"><input class="edit-words" id="edit_word_input_'.$id.'" style="margin-left:5px;margin-bottom:10px;" type="text" value="'.$word.'"/></div>
      <div style="display:flex;"><input class="edit-words" id="edit_keywords_input_'.$id.'" style="margin-left:5px;" type="text" value="'.$keywords.'"/></div>
      
      </td>
    	<td style="vertical-align: top;padding-top: 10px;">'.$edit_word_selects.'</td>
      <td style="vertical-align: top;padding-top: 10px;"><input style="width: 68px;" class="edit-words" id="edit_week_input_'.$id.'" type="number" value="'.$week.'"/></td>
 		 </tr>';

      $card .= '<div data-word="'.$word.'" data-week="'.$week.'" data-filter="'.$category.'" class="col '.$week.' '.$category.' card-container">
      <div class="card shadow card-flip">
        <div class="front card-block">
        <i style="color:'.$colour.'" class="bi tag2 bi-tag-fill"></i>
        <div style="height:150px;"> 
        <h4 class="card-title">'.$word.'</h4>
        '.$keyword_str.'

        </div>
        <a class="auslan-link" target="_blank" href="https://auslan.org.au/dictionary/search/?query='.$word.'&category=all"><i class="bi bi-box-arrow-up-right"></i> </a>
        </div>
        <div class="back card-block">
          <div>
          <img class="giffy" src="'.$gif.'" alt="'.$word.' GIF"> 
          </div>

        </div>
      </div>
    </div>';

  }
}

$searched = "false";
$kk_num = 0;
$query = "";

if(isset($_GET['query'])){

  $searched = "true";
  $query = $_GET['query'];

  $card = '';
  $kk_num = 0;
  $chars = preg_split("/[\s,]+/", $_GET['query'], -1, PREG_SPLIT_DELIM_CAPTURE);
foreach($chars as $char){

  $auslan_sql_query = $conn->query("SELECT a.*, b.* FROM auslan AS a 
  INNER JOIN auslan_categories AS b ON b.id = a.category_id WHERE word LIKE '%".$char."%' ORDER BY a.word ASC");
if($auslan_sql_query->num_rows > 0){
  while($row = $auslan_sql_query->fetch_assoc()){
    $kk_num++;
      $id = $row['id'];
      $word = $row['word'];
      $category = $row['category'];
      $gif = $row['gif'];
      $week = $row['week'];
      $colour = $row['hex_colour'];

      $card .= '<div data-word="'.$word.'" data-week="'.$week.'" data-filter="'.$category.'" class="col '.$week.' '.$category.' card-container">
      <div class="card shadow card-flip">
        <div class="front card-block">
        <i style="color:'.$colour.'" class="bi tag2 bi-tag-fill"></i>
        <div style="height:150px;"> <h4 class="card-title">'.$word.'</h4>
        </div>
        <a class="auslan-link" target="_blank" href="https://auslan.org.au/dictionary/search/?query='.$word.'&category=all"><i class="bi bi-box-arrow-up-right"></i> </a>
        </div>
        <div class="back card-block">
          <div>
          <img class="giffy" src="'.$gif.'" alt="'.$word.' GIF"> 
          </div>

        </div>
      </div>
    </div>';

  }
}

}


}



if(isset($_POST['advanced_search'])){
  //Load DOM Holder for our HTML
  $dom = new DomDocument();
  $card = '';
  $keywords = explode(" ", $_POST['advanced_search']);

  $found = 0;

  $advance_filter_text = 'Advanced search: '.$_POST['advanced_search'].'<i id="remove_search_filter" class=" bi bi-x-circle-fill"></i>';

    foreach($keywords as $word){
         
      $formatted_word = ucwords($word);
  //Go to static webpage if it exists for the keyword
  $dom->loadHtml(file_get_contents('https://auslan.org.au/dictionary/words/'.$word.'-1.html'));
  $finder = new DomXPath($dom);
    
  $found++;
  $i = 0;
 
  //Go through all the tags of "source"
  $sel = $dom->getElementsByTagName("source");

  foreach ($sel as $select){
      //If it has a type of video then we know we've found it 
        if ($select->getAttribute("type") == "video/mp4") {
          $i++;
          if($i <= 1){

            $card .= '<div data-word="'.$word.'"  class="col card-container">
            <div class="card shadow card-flip">
              <div class="front card-block">
              <div style="height:150px;"> <h4 class="card-title">'.$formatted_word.'</h4>
              </div>
              <a class="auslan-link" target="_blank" href="https://auslan.org.au/dictionary/search/?query='.$word.'&category=all"><i class="bi bi-box-arrow-up-right"></i> </a>
              </div>
              <div class="back card-block">
                <div>
                <video controls autoplay loop muted class="giffy" src="'.$select->getAttribute('src').'"></video>
                </div>
      
              </div>
            </div>
          </div>';

          }
           }
        }
        }
}


?>
