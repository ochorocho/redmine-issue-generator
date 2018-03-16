<?php

namespace Redmine;

Class IssueGenerator
{

    /**
     * Issues to create
     *
     * @var int
     */
    protected $issueCount = 2;

    /**
     * Set redmine url
     *
     * @var string $url
     */
    protected $url = "http://redmine.example.org";

    /**
     * @var string $token
     */
    protected $token = "";

    /**
     * @var array $users
     */
    protected $users = ["admin"];

    /**
     * @var array $projects
     */
    protected $projects = [];

    /**
     * @var string $subject
     */
    protected $subject = "";

    /**
     * @var string $text
     */
    protected $text = "";

    /**
     * Range for Billing Hours [minValue,maxValue]
     *
     * @var array $billingHoursRange
     */
    protected  $billingHoursRange = [0,60];

    /**
     * Description length [minValue,maxValue]
     *
     * @var array $textLengthRange
     */
    protected $textLengthRange = [64,240];

    /**
     * Subject length [minValue,maxValue]
     *
     * @var array $subjectLengthRange
     */
    protected $subjectLengthRange = [];

    /**
     * Period of das in which is used to create the random date within
     * Range is $today + $randomDateDays
     *
     * @var int $randomDateDays
     */
    protected $randomDateDays = 364;
    /**
     * $randomDate - $dateLowRange
     *
     * @var array $dateLowRange
     */
    protected $dateLowRange = [1,5];

    /**
     * $randomDate + $dateHighRange
     *
     * @var array $dateHighRange
     */
    protected $dateHighRange = [1,5];

    /**
     * @return string
     */
    public function getUrl()
    {
        return $this->url;
    }

    /**
     * @param string $url
     */
    public function setUrl($url)
    {
        $this->url = $url;
    }

    /**
     * @return string
     */
    public function getToken()
    {
        return $this->token;
    }

    /**
     * @param string $token
     */
    public function setToken($token)
    {
        $this->token = $token;
    }

    /**
     * @return string
     */
    public function getUsers()
    {
        return $this->users;
    }

    /**
     * @param string $users
     */
    public function setUsers($users)
    {
        $this->users = $users;
    }

    /**
     * @return string
     */
    public function getProjects()
    {
        return $this->projects;
    }

    /**
     * @param string $projects
     */
    public function setProjects($projects)
    {
        $this->projects = $projects;
    }

    /**
     * @return string
     */
    public function getText()
    {
        return $this->text;
    }

    /**
     * @param string $text
     */
    public function setText($text)
    {
        $this->text = $text;
    }

    /**
     * @return string
     */
    public function getSubject()
    {
        return $this->subject;
    }

    /**
     * @param string $subject
     */
    public function setSubject($subject)
    {
        $this->subject = $subject;
    }

    /**
     * @return int
     */
    public function getIssueCount()
    {
        return $this->issueCount;
    }

    /**
     * @param int $issueCount
     */
    public function setIssueCount($issueCount)
    {
        $this->issueCount = $issueCount;
    }

    /**
     * @return array
     */
    public function getBillingHoursRange()
    {
        return $this->billingHoursRange;
    }

    /**
     * @param array $billingHoursRange
     */
    public function setBillingHoursRange($billingHoursRange)
    {
        $this->billingHoursRange = $billingHoursRange;
    }

    /**
     * @return array
     */
    public function getTextLengthRange()
    {
        return $this->dtextLengthRange;
    }

    /**
     * @param $textLengthRange
     */
    public function setTextLengthRange($textLengthRange)
    {
        $this->textLengthRange = $textLengthRange;
    }

    /**
     * @return array
     */
    public function getSubjectLengthRange()
    {
        return $this->subjectLengthRange;
    }

    /**
     * @param array $subjectLengthRange
     */
    public function setSubjectLengthRange($subjectLengthRange)
    {
        $this->subjectLengthRange = $subjectLengthRange;
    }

    /**
     * @return int
     */
    public function getRandomDateDays()
    {
        return $this->randomDateDays;
    }

    /**
     * @param int $randomDateDays
     */
    public function setRandomDateDays($randomDateDays)
    {
        $this->randomDateDays = $randomDateDays;
    }

    /**
     * @return array
     */
    public function getDateLowRange()
    {
        return $this->dateLowRange;
    }

    /**
     * @param array $dateLowRange
     */
    public function setDateLowRange($dateLowRange)
    {
        $this->dateLowRange = $dateLowRange;
    }

    /**
     * @return array
     */
    public function getDateHighRange()
    {
        return $this->dateHighRange;
    }

    /**
     * @param array $dateHighRange
     */
    public function setDateHighRange($dateHighRange)
    {
        $this->dateHighRange = $dateHighRange;
    }

    /**
     * Create issues
     */
    public function createIssues() {
        $client = new Client($this->getUrl(), $this->getToken());
        $allUser = $client->user->all();

        /**
         * Available users
         */
        echo 'Available users:' . PHP_EOL;
        foreach ($allUser['users'] as $user) {
            echo $user['login'] . ' ';
        }
        echo PHP_EOL;
        echo PHP_EOL;

        /**
         * Available trackers
         */
        $allTracker = $client->tracker->all();
        echo 'Available trackers:' . PHP_EOL;
        foreach ($allTracker['trackers'] as $tracker) {
            echo $tracker['name'] . ' ';
            $trackers[] = $tracker['name'];
        }
        echo PHP_EOL;

        /**
         * Loop through $projects * $users * $issueCount
         */
        $counter = 0;
        foreach ($this->getProjects() as $project) {
            foreach ($this->getUsers() as $user) {
                foreach(range(1,$this->getIssueCount()) as $index) {

                    $baconFiller = json_decode(file_get_contents("https://baconipsum.com/api/?type=meat-and-filler"));

                    $doneRatio = rand(0, 10);
                    $billingHours = $this->getBillingHoursRange();
                    $descriptionLength = $this->getTextLengthRange();
                    $subjectLength = $this->getSubjectLengthRange();
                    $dateLow = $this->getDateLowRange();
                    $dateHigh = $this->getDateHighRange();

                    $days = rand(0,364);

                    $date = new \DateTime();
                    $date->format('Y-m-d');
                    $isseDate = $date->modify('+'.$days.' days');

                    $subject = !empty($this->getSubject()) ? $this->getSubject() : $baconFiller[0];
                    $text = !empty($this->getText()) ? $this->getText() : $baconFiller[1];

                    $i = [
                        'project_id'  => $project,
                        'subject'     => substr($subject, 0, rand($subjectLength[0],$subjectLength[1])),
                        'description' => substr($text, 0, rand($descriptionLength[0],$descriptionLength[1])),
                        'assigned_to' => $user,
                        'editor_id' => $client->user->getIdByUsername($user),
                        'start_date' => $isseDate->modify('-'.rand($dateLow[0],$dateLow[1]).' days')->format('Y-m-d'),
                        'due_date' => $isseDate->modify('+'.rand($dateHigh[0],$dateHigh[1]).' days')->format('Y-m-d'),
                        'done_ratio' => $doneRatio . '0',
                        'estimated_hours' => rand($billingHours[0], $billingHours[1]),
                        'tracker_id' => $client->tracker->getIdByName($trackers[array_rand($trackers)])
                    ];

                    $client->issue->create($i);
                    $issue = '';
                    foreach ($i as $key => $value) {
                        $issue .= "  " . $key . ': ' . $value . PHP_EOL;
                    }
                    echo "Created :" . PHP_EOL . $issue . PHP_EOL;
                    $counter++;
                }
            }
        }
        echo "-> $counter Issues created" . PHP_EOL;
    }
}