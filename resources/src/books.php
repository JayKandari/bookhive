<?php 
   namespace db;
   use PDO;
   class book
   {
      public $id;
      public $title;
      public $author;
      public $category;
      public $myDate;
      public $qty;
      public $available;
      public $pdo;
      public function __construct()
      {
         $this->pdo= new PDO('mysql:host=localhost;port=3307;dbname=bookhive', 'anjali', 'ctc');
      }
      public function disp_book($recent)
      {
         $stmt2 = $this->pdo->query('SELECT * FROM Book order by added_on desc');
         $op=array();
         if($recent == 'no')
         {
            while($row=$stmt2->fetch(PDO::FETCH_ASSOC))
            {
               array_push($op,array('id'=>$row['id'],'title'=>$row['title'],'path'=>$row['ipath'],'author'=>$row['author'],'added_on'=>$row['added_on'],'category'=>$row['category'],'available'=>$row['available']));
            }
         }
         else
         {
            $count=1;
            while($row=$stmt2->fetch(PDO::FETCH_ASSOC))
            {
               if ($count<=10)
               {
                  
                  array_push($op,array('id'=>$row['id'],'title'=>$row['title'],'path'=>$row['ipath'],'author'=>$row['author'],'added_on'=>$row['added_on'],'category'=>$row['category'],'available'=>$row['available']));
                  $count=$count+1;
               }    
            }
         }
         return $op;
      }
      public function search ($name)
      {
         $stmt2 = $this->pdo->query('SELECT * FROM Book where title LIKE "%'.$name.'%"');
         $op=array();
         $row=0;
         if ($stmt2->fetch(PDO::FETCH_ASSOC))
         {
            while($row=$stmt2->fetch(PDO::FETCH_ASSOC))
            {
               array_push($op[$row],(array('id'=>$row['id'],'title'=>$row['title'],'path'=>$row['path'],'author'=>$row['author'],'added_on'=>$row['added_on'])));
               $row=$row+1;
            }
         }
         else
         {
            echo "Sorry ! No books found!";
         }
         return $op;
      }
      public function edit()
      {
         $stmt2 = $this->pdo->query('SELECT * FROM Book');
         while($row=$stmt2->fetch(PDO::FETCH_ASSOC))
         {
            echo '<form method="post">';
            echo "<tr>";
            echo '<td><input type="number" name="id" value="'.$row['id'].'" readonly></input></td>';
            echo '<td><input type="text" name="title" value="'.$row['title'].'"></input></td>';
            echo '<td><input type="text" name="author" value="'.$row['author'].'"></input></td>';
            echo '<td><input type="text" name="category" value="'.$row['category'].'"></input></td>';
            echo '<td><input type="date" name="added_on" value="'.$row['added_on'].'"></input></td>';
            echo '<td><input type="number" name="qty" value="'.$row['qty'].'"></input></td>';
            echo '<td><input type="number" name="available" value="'.$row['available'].'"></input></td>';
            echo '<td><input type="text" name="ipath" value="'.$row['ipath'].'"></input></td>';
            echo '<td><button name="update_button" class="iconbtnedit"><i class="fas fa-edit"></i></button></td>';
            echo '<td><button name="delete_button" class="iconbtndelete"><i class="fas fa-trash"></i></button></td>';
            echo "</tr>"; 
            echo '</form>';    
         }
         if (isset($_POST["update_button"]))
         {
            $sql='UPDATE Book SET title=?,author=?,category=?,added_on=?,qty=?,available=?,ipath=? where id=?';
            $stmt = $this->pdo->prepare($sql);
            if ($stmt->execute([$_POST["title"],$_POST["author"],$_POST["category"],$_POST["added_on"],$_POST["qty"],$_POST["available"],$_POST["ipath"],$_POST["id"]]) === TRUE )
            {
               header("LOCATION: listbookedit.php");
            }
            else
            {
               echo "<p id='e'>Information edit unsuccessful. Try Again !<p>";
            }
         }
         if (isset($_POST["delete_button"]))
         {
            $stmt2 = $this->pdo->query('DELETE FROM Book where id='. $_POST["id"]);
            header("LOCATION: admindash.php");
         }
      }
      public function issue($bid)
      {
         $sql1 = "SELECT qty FROM Book WHERE id='". $bid."'";
         $stmt1=$this->pdo->query($sql1);
         $row1=$stmt1->fetch(PDO::FETCH_ASSOC);
         $q=number_format($row1["qty"]);
         $q=$q-1;
         $a=1;
         if ($q<=0)
         {
            $a=0;
         }
         $sql='UPDATE Book SET qty=?,available=? where id=?';
         $stmt = $this->pdo->prepare($sql);
         if ($stmt->execute([$q,$a]) === TRUE )
         {
            header("LOCATION: homepagecontent.php");
         }
      }
   }
?>