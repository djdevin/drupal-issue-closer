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
   * @Then I close all :project issues with version :version and message:
   */
  public function iCloseAllIssuesWithVersionAndMessage($project, $version, PyStringNode $closeText) {
    $closeText = (string) $closeText;

    $this->minkContext->visit("https://www.drupal.org/api-d7/node.json?type=project_module&field_project_machine_name=$project");
    $json = $this->minkContext->getSession()->getPage()->getContent();
    $project = json_decode($json);
    $project_id = $project->list[0]->nid;

    $closeStatus = array(1, 13, 8, 14, 15, 4, 16);
    foreach ($closeStatus as $status) {
      $this->minkContext->visit("https://www.drupal.org/api-d7/node.json?type=project_issue&field_project=$project_id&field_issue_version=$version&field_issue_status=$status&limit=100");
      $json = $this->minkContext->getSession()->getPage()->getContent();
      $issues = json_decode($json);
      foreach ($issues->list as $issue) {
        print "Will update $issue->nid: $issue->field_issue_version - $issue->title\n";
        $this->minkContext->visit("/node/$issue->nid");
        $this->minkContext->assertFieldNotContains('Status', 'Closed (outdated)');
        $this->minkContext->selectOption('Status', 'Closed (outdated)');
        $this->minkContext->fillField('Comment', $closeText);
        $this->minkContext->pressButton('Save');
      }
    }
  }

}
