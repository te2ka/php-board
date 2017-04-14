<?php /* スレッド一覧を表示するページ */
require_once 'base_class.php';

class ThreadsController extends BaseClass {
  function __construct() {
    $this->title = 'スレッド一覧';

    parent::__construct();
  }

  function generate_html() {
    $this->body .= $this->generate_form();
    $this->body .= $this->generate_thread_list();
  }

  private function generate_form() {
    $retval = '';

    $retval .= '<form action="/board/create_thread.php" method="post" class="form-inline">';
    $retval .= '<input type="text" name="name" placeholder="スレッド名を入力" class="form-control col-md-10" required />';
    $retval .= '<input type="submit" value="スレッドを作成" class="btn btn-primary btn-sm" />';
    $retval .= '</form>';

    return $retval;
  }

  private function generate_thread_list() {
    $retval = '';

    $retval .= '<table class="table table-striped">';
    $retval .= '<thead><tr><th>スレッド名</th><th>作成日時</th></tr></thead>';
    $retval .= '<tbody>';
    foreach ($this->obtain_threads() as $thread) {
      $retval .= '<tr>';
      $retval .= "<td>{$thread['name']}</td>";
      $retval .= "<td>{$thread['created_at']}</td>";
      $retval .= '</tr>';
    }
    $retval .= '</tbody>';
    $retval .= '</table>';

    return $retval;
  }

  private function obtain_threads() {
    return $this->database->select('threads', '*', array('ORDER' => array('id' => 'DESC')));
  }
}

$controller = new ThreadsController();
$controller->generate_html();

include 'layout.php';