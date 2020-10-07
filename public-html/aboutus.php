<?php
require $_SERVER['DOCUMENT_ROOT'] . '/../vendor/autoload.php';

use template\Page;

$new = new Page;
$content = <<<EOT
<div class="main_content">
  <div class="row">
    <div class="column">
      <div class="card">
        <img
          src="../asset/images/aastha.jpg"
          alt="Avatar"
          style="width: 100%"
        />
        <h3>Aastha Shrivastava</h3>
        <p>Drupal Intern</p>
      </div>
    </div>
    <div class="column">
      <div class="card">
        <img
          src="../asset/images/pragati.jpeg"
          alt="Avatar"
          style="width: 100%"
        />
        <h3>Pragati Kanade</h3>
        <p>Drupal Intern</p>
      </div>
    </div>
  </div>

  <div class="row">
    <div class="column">
      <div class="card">
        <img src="../asset/images/a.jpg" alt="Avatar" style="width: 100%" />
        <h3>Anjali Rathod</h3>
        <p>Drupal Intern</p>
      </div>
    </div>

    <div class="column">
      <div class="card">
        <img
          src="../asset/images/alphonse.jpg"
          alt="Avatar"
          style="width: 100%"
        />
        <h3>Alphons Jaimon</h3>
        <p>Drupal Intern</p>
      </div>
    </div>
  </div>
</div>
EOT;
$new->constructPage($content);
