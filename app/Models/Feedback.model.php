<?php

namespace Models;

use Core\Database;
use Core\Model;

class Feedback
{

  public function fetchNumberOfFeedbacks(): int
  {
    return Model::table('feedbacks')->count();
  }
  public function fetchFeedbacks($sort = 'DESC') : array {
    return Model::table('feedbacks')->select()->orderBy('create_date', $sort)->get();
  }
  public function fetchFeedbackDetails(string $feedbackID = ''): array
  {
    return Model::table('feedbacks')->select()->where('feedback_ID', $feedbackID)->get();
  }
}