<?php

require_once('Model/DBModel.php');

class BookCollectionTest extends \Codeception\Test\Unit
{
    /**
     * @var \UnitTester
     */
    protected $tester;
    protected $dbModel;
    
    protected function _before()
    {
        $db = new PDO(
                'mysql:host=localhost;dbname=test;charset=utf8',
                'root',
                '',
                array(PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION)
            );
        $this->dbModel = new DBModel($db);
    }

    protected function _after()
    {
    }

    // Test that all books are retrieved from the database
    public function testGetBookList()
    {
        $bookList = $this->dbModel->getBookList();

        // Sample tests of book list contents
        $this->assertEquals(count($bookList), 3);
        $this->assertEquals($bookList[0]->id, 1);
        $this->assertEquals($bookList[0]->title, 'Jungle Book');
        $this->assertEquals($bookList[1]->id, 2);
        $this->assertEquals($bookList[1]->author, 'J. Walker');
        $this->assertEquals($bookList[2]->id, 3);
        $this->assertEquals($bookList[2]->description, 'Written by some smart gal.');
    }

    // Tests that information about a single book is retrieved from the database
    public function testGetBook()
    {
        $book = $this->dbModel->getBookById(1);

        // Sample tests of book list contents
        $this->assertEquals($book->id, 1);
        $this->assertEquals($book->title, 'Jungle Book');
        $this->assertEquals($book->author, 'R. Kipling');
        $this->assertEquals($book->description, 'A classic book.');
    }

    // Tests that get book operation fails if id is not numeric
    public function testGetBookRejected()
    {
         
        //$this->tester->expectException(InvalidArgumentException::class, function() {
        //    $this->dbModel->getBookById("1'; drop table book;--");
        //});
    }

    // Tests that a book can be successfully added and that the id was assigned. Four cases should be verified:
    //   1. title=>"New book", author=>"Some author", description=>"Some description" 
    //   2. title=>"New book", author=>"Some author", description=>""
    //   3. title=>"<script>document.body.style.visibility='hidden'</script>",
    //      author=>"<script>document.body.style.visibility='hidden'</script>",
    //      description=>"<script>document.body.style.visibility='hidden'</script>"
    
	public function testAddBook1()
	{
	$testValues = ['title' => 'New book',
                       'author' => 'Some author',
                       'description' => 'Some description'];
		
        $book = new Book($testValues['title'], $testValues['author'], $testValues['description']);
        $this->dbModel->addBook($book);
        
        // Id was successfully assigned
        $this->assertEquals($book->id, 4);
        
        $this->tester->seeNumRecords(4, 'book');
        // Record was successfully inserted
        $this->tester->seeInDatabase('book', ['id' => 4,
                                              'title' => $testValues['title'],
                                              'author' => $testValues['author'],
                                              'description' => $testValues['description']]);
	}

	public function testAddBook2()
	{
	$testValues = ['title' => 'New book',
                       'author' => 'Some author',
                       'description' => ''];
		//Test
        $book = new Book($testValues['title'], $testValues['author'], $testValues['description']);
        $this->dbModel->addBook($book);
        
        // Id was successfully assigned
        $this->assertEquals($book->id, 4);
        
        $this->tester->seeNumRecords(4, 'book');
        // Record was successfully inserted
        $this->tester->seeInDatabase('book', ['id' => 4,
                                              'title' => $testValues['title'],
                                              'author' => $testValues['author'],
                                              'description' => $testValues['description']]);
	}

	public function testAddBook3()
    {
	    $testValues = ['title' => "<script>document.body.style.visibility='hidden'</script>",
                        'author' => "<script>document.body.style.visibility='hidden'</script>",
                        'description' => "<script>document.body.style.visibility='hidden'</script>"];
        
        $book = new Book($testValues['title'], $testValues['author'], $testValues['description']);
        $this->dbModel->addBook($book);
        
        // Id was successfully assigned
        $this->assertEquals($book->id, 4);
        
        $this->tester->seeNumRecords(4, 'book');
        // Record was successfully inserted
        $this->tester->seeInDatabase('book', ['id' => 4,
                      'title' => $testValues['title'],
                      'author' => $testValues['author'],
                      'description' => $testValues['description']]);
    }

    // Tests that adding a book fails if id is not numeric
    public function testAddBookRejectedOnInvalidId()
    {
	    $testValues = ['title' => 'New book',
                       'author' => 'Some author',
                       'description' => '',
					   'id' => 'a'];
        $book = new Book($testValues['title'], $testValues['author'],
		$testValues['description'],$testValues['id']);
		
	try {
   $this->dbModel->addBook($book);
   $this->assertInstanceOf(InvalidArgumentException::class, null);
        } 
   catch (InvalidArgumentException $e) {
   }
   }

    // Tests that adding a book fails if mandatory fields are left blank
    public function testAddBookRejectedOnMandatoryFieldsMissing()
    {
	$testValues = ['title' => '',
                       'author' => '',
                       'description' => '',
					   'id' => ''];
        $book = new Book($testValues['title'], $testValues['author'],
		$testValues['description'],$testValues['id']);
		
	try {
   $this->dbModel->modifyBook($book);
   $this->assertInstanceOf(InvalidArgumentException::class, null);
        } 
   catch (InvalidArgumentException $e) {
   }
    }

    // Tests that a book record can be successfully modified. Three cases should be verified:
    //   1. title=>"New book", author=>"Some author", description=>"Some description"
    //   2. title=>"New book", author=>"Some author", description=>""
    //   3. title=>"<script>document.body.style.visibility='hidden'</script>",
    //      author=>"<script>document.body.style.visibility='hidden'</script>",
    //      description=>"<script>document.body.style.visibility='hidden'</script>"
    public function testModifyBook1()
    {
	$testValues = ['title' => 'Jungle Book',
                       'author' => 'R. Kipling',
                       'description' => 'A very classic book',
					   'id' => 1];
	$book = new Book($testValues['title'], $testValues['author'], $testValues['description'], $testValues['id']);
	$this->dbModel->modifyBook($book);
	
	$this->tester->seeInDatabase('book', ['id' => 1,
                                              'title' => $testValues['title'],
                                              'author' => $testValues['author'],
                                              'description' => $testValues['description']]);
    }
    
	public function testModifyBook2()
    {
	$testValues = ['title' => 'Jungle Book',
                       'author' => 'R. Kipling',
                       'description' => '',
					   'id' => 1];
	$book = new Book($testValues['title'], $testValues['author'], $testValues['description'], $testValues['id']);
	$this->dbModel->modifyBook($book);
	
	$this->tester->seeInDatabase('book', ['id' => 1,
                                              'title' => $testValues['title'],
                                              'author' => $testValues['author'],
                                              'description' => $testValues['description']]);
    }

	public function testModifyBook3()
    {
	     $testValues = ['title'=>"<script>document.body.style.visibility='hidden'</script>",
         'author'=>"<script>document.body.style.visibility='hidden'</script>",
         'description'=>"<script>document.body.style.visibility='hidden'</script>",'id' => 1];
	     
		 $book = new Book($testValues['title'], $testValues['author'], $testValues['description'], $testValues['id']);
	     $this->dbModel->modifyBook($book);
	
	     $this->tester->seeInDatabase('book', ['id' => 1,
                                              'title' => $testValues['title'],
                                              'author' => $testValues['author'],
                                              'description' => $testValues['description']]);
    }
    // Tests that modifying a book record fails if id is not numeric
    public function testModifyBookRejectedOnInvalidId()
    {
	$testValues = ['title' => 'New book',
                       'author' => 'Some author',
                       'description' => '',
					   'id' => 'a'];
        $book = new Book($testValues['title'], $testValues['author'],
		$testValues['description'],$testValues['id']);
		
	try {
   $this->dbModel->modifyBook($book);
   $this->assertInstanceOf(InvalidArgumentException::class, null);
        } 
   catch (InvalidArgumentException $e) {
   }
    }
    
    // Tests that modifying a book record fails if mandatory fields are left blank
    public function testModifyBookRejectedOnMandatoryFieldsMissing()
    {
	$testValues = ['title' => '',
                       'author' => '',
                       'description' => ''];
        $book = new Book($testValues['title'], $testValues['author'],
		$testValues['description']);
		
	try {
   $this->dbModel->modifyBook($book);
   $this->assertInstanceOf(InvalidArgumentException::class, null);
        } 
   catch (InvalidArgumentException $e) {
   }
    }
    
    // Tests that a book record can be successfully deleted.
    public function testDeleteBook()
    {
	$id = 1;
	$this->dbModel->deleteBook($id);
	$this->tester->dontSeeInDatabase('book', ['id' => '$id']);
    }
    
    // Tests that deleting a book fails if id is not numeric
    public function testDeleteBookRejectedOnInvalidId()
    {
	$id = 's';

	try{
	$this->dbModel->deleteBook($id);
	$this->assertInstanceOf(InvalidArgumentException::class, null);
        } 
   catch (InvalidArgumentException $e) {
   }
    }
}