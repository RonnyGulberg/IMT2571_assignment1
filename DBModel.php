<?php
/** The Model implementation of the IMT2571 Assignment #1 MVC-example, storing data in a MySQL database using PDO.
 * @author Rune Hjelsvold
 * @see http://php-html.net/tutorials/model-view-controller-in-php/ The tutorial code used as basis.
 */

require_once("AbstractModel.php");
require_once("Book.php");

/** The Model is the class holding data about a collection of books.
 * @todo implement class functionality.
 */
class DBModel extends AbstractModel
{
    protected $db = null;
    
    /**
     * @param PDO $db PDO object for the database; a new one will be created if no PDO object
     *                is passed
     * @todo Implement function using PDO and a real database.
     * @throws PDOException
     */
    public function __construct($db = null)
    {
        if ($db) {
            $this->db = $db;
        } else {
            $this->db = new PDO('mysql:host=localhost;dbname=test;charset=utf8mb4', 'root', '');
        }
    }
    
    /** Function returning the complete list of books in the collection. Books are
     * returned in order of id.
     * @return Book[] An array of book objects indexed and ordered by their id.
     * @todo Implement function using PDO and a real database.
     * @throws PDOException
     */
    public function getBookList()
    {
       $booklist = array();
	   $sth = $this->db->prepare("SELECT title,author,description,id FROM book");
       $sth->execute();
       $result = $sth->fetchAll();
	  
	   foreach($result as $row)
	   {
	   	   $booklist[] = new Book($row[0],$row[1],$row[2],$row[3]);
	   }
        return $booklist;
    }
    
    /** Function retrieving information about a given book in the collection.
     * @param integer $id the id of the book to be retrieved
     * @return Book|null The book matching the $id exists in the collection; null otherwise.
     * @todo Implement function using PDO and a real database.
     * @throws PDOException
     */
    public function getBookById($id)
    {
        $book = null; 
	    $sth = $this->db->prepare("SELECT title,author,description,id FROM book WHERE id = $id");
        $sth->execute();
        $result = $sth->fetchAll();
	  
	    foreach($result as $row)
	    {
	   	   $book = new Book($row[0],$row[1],$row[2],$row[3]);
	    }
        return $book;
    }
    
    /** Adds a new book to the collection.
     * @param Book $book The book to be added - the id of the book will be set after successful insertion.
     * @todo Implement function using PDO and a real database.
     * @throws PDOException
     */
    public function addBook($book)
    {
	self::verifyBook($book);
	//self::verifyID($book->id);

	$booklist=$this->db->prepare("INSERT INTO book(title,author,description) VALUES(:title,:author,:description)");
    $booklist->bindValue(':title', $book->title, PDO::PARAM_STR);
	$booklist->bindValue(':author', $book->author, PDO::PARAM_STR);
	$booklist->bindValue(':description', $book->description, PDO::PARAM_STR);
	$booklist->execute(array(':title' => $book->title,':author' => $book->author,':description' => $book->description));
	$book->id=$this->db->lastInsertId();
	}

    /** Modifies data related to a book in the collection.
     * @param Book $book The book data to be kept.
     * @todo Implement function using PDO and a real database.
     * @throws PDOException
    */
    public function modifyBook($book)
    {
	self::verifyBook($book);

	$sth = "UPDATE book SET title=?, author=?, description=? WHERE id=?";
    $this->db->prepare($sth)->execute([$book->title, $book->author, $book->description, $book->id]);
    }

    /** Deletes data related to a book from the collection.
     * @param $id integer The id of the book that should be removed from the collection.
     * @todo Implement function using PDO and a real database.
     * @throws PDOException
    */
    public function deleteBook($id)
    {
	self::verifyId($id);
	$sth=$this->db->prepare("DELETE FROM book WHERE id=:id");
    $sth->bindParam(":id",$id,PDO::PARAM_INT);
    $sth->execute();
    }
}
