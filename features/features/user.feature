Feature: User management

  @read
  Scenario: As Admin I can list active users
    Given I am authenticated as admin
    When I try to get a list of users
    Then I see a list of users

#  @read
#  Scenario: As user I can't list active users
#    Given I am authenticated as user
#    When I try to get a list of users
#    Then I should be unauthorized
#
#  @read
#  Scenario: As Admin I can see user info
#    Given I am authenticated as admin
#    When I try to get user infos
#    Then I see user infos
#
#  @read
#  Scenario: As user I can't see user info
#    Given I am authenticated as user
#    When I try to get user infos
#    Then I should be unauthorized
#
#  @read
#  Scenario: As user I can see my user info
#    Given I am authenticated as user
#    When I try to get my user infos
#    Then I see my user infos
#
#  Scenario: As Admin I can create a user
#    Given I am authenticated as admin
#    When I try to create a user
#    Then I see this user infos
#
#  @read
#  Scenario: As user I can't create a user
#    Given I am authenticated as user
#    When I try to create a user
#    Then I should be unauthorized
#
#  Scenario: As Admin I can update user infos
#    Given I am authenticated as admin
#    When I try to update user infos
#    Then I see this user infos
#
#  @read
#  Scenario: As user I can't update user infos
#    Given I am authenticated as user
#    When I try to update user infos
#    Then I should be unauthorized
#
#  Scenario: As user I can update my user infos
#    Given I am authenticated as user
#    When I try to update my user infos
#    Then I see this user infos
#
#  @read
#  Scenario: As Admin I can't delete a user
#    Given I am authenticated as admin
#    When I try to delete a user
#    Then I should be unauthorized
