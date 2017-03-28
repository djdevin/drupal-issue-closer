<?php

use Behat\Behat\Context\Context;
use Behat\Behat\Context\SnippetAcceptingContext;
use Behat\Gherkin\Node\PyStringNode;
use Behat\Gherkin\Node\TableNode;
use Behat\Behat\Hook\Scope\BeforeScenarioScope;

/**
 * Defines application features from the specific context.
 */
class CustomContext implements Context, SnippetAcceptingContext {

  /** @var \Behat\MinkExtension\Context\MinkContext */
  private $minkContext;

  /** @BeforeScenario */
  public function gatherContexts(BeforeScenarioScope $scope) {
    $environment = $scope->getEnvironment();

    $this->minkContext = $environment->getContext('Behat\MinkExtension\Context\MinkContext');
  }

  /**
   * @Then I close all the active :version issues
   */
  public function doDrupalThings($version) {
    $closeStatus = array(1, 13, 8, 14, 15, 4, 16);
    foreach ($closeStatus as $status) {
      $this->minkContext->visit("https://www.drupal.org/api-d7/node.json?type=project_issue&field_project=26481&field_issue_version=$version&field_issue_status=$status&limit=100");
      $json = $this->minkContext->getSession()->getPage()->getContent();
      $issues = json_decode($json);
      foreach ($issues->list as $issue) {
        print "Will update $issue->nid: $issue->field_issue_version - $issue->title\n";
        //
        $this->minkContext->visit("/node/$issue->nid");
        $this->minkContext->assertFieldNotContains('Status', 'Closed (outdated)');
        $this->minkContext->selectOption('Status', 'Closed (outdated)');
        $this->minkContext->fillField('Comment', 'This issue is being closed because it was filed against a version that is no longer supported. If the issue still persists in the latest version of Quiz, please open a new issue.');
        $this->minkContext->pressButton('Save');
        // */
      }
    }
  }

}
