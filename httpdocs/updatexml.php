<?php
  $doc = new DOMDocument();
  $doc->load( 'books.xml' );
  
  $books = $doc->getElementsByTagName( "book" );
  foreach( $books as $book )
  {
  $authors = $book->getElementsByTagName( "author" );
  $author = $authors->item(0)->nodeValue;
  
  $publishers = $book->getElementsByTagName( "publisher" );
  $publisher = $publishers->item(0)->nodeValue;
  
  $titles = $book->getElementsByTagName( "title" );
  $title = $titles->item(0)->nodeValue;
  
  echo "$title - $author - $publisher\n";
  }
  ?>