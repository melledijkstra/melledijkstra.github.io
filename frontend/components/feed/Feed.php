<?php

namespace frontend\components\feed;
use \Yii;
use yii\helpers\Url;

/**
 * Class Feed to create a Atom RSS feed
 * @package frontend\components\feed
 * @see https://validator.w3.org/feed/docs/atom.html
 */
class Feed {

    /**
     * Identifies the feed using a universally unique and permanent URI.
     * If you have a long-term, renewable lease on your Internet domain name, then you can feel free to use your website's address.
     * @var string
     */
    public $id;

    /**
     * Contains a human readable title for the feed.
     * Often the same as the title of the associated website.
     * This value should not be blank.
     * @var string
     */
    public $title;

    /**
     * Indicates the last time the feed was modified in a significant way.
     * Can be either unix timestamp DateTime object or a string which can be formatted
     * @var int|\DateTime|string
     */
    public $updated;

    /**
     * Language identifier of the feed
     * @var string
     */
    public $language;

    /**
     * Identifies a related Web page. The type of relation is defined by the rel attribute.
     * A feed is limited to one alternate per type and hreflang.
     * A feed should contain a link back to the feed itself.
     * @var string
     */
    public $link;

    /**
     * Link to the page itself
     * ```
     * <link href="http://example.com/feed" rel="self" />
     * ```
     * @var string
     */
    public $linkSelf;

    /**
     * TODO: Able to add multiple authors
     * Name of the author of the feed. Optional
     * You need to specify $authorEmail also when declaring this field
     *
     * @see $authorEmail
     * @var string
     */
    public $author;

    /**
     * Email of the author of the feed. Optional
     * You need to specify $author also when declaring this field
     *
     * @see $author
     * @var string
     */
    public $authorEmail;

    /**
     * Specifies a category that the feed belongs to. A feed may have multiple category elements.
     *
     * example: ['sports', 'tech']
     * will generate:
     * ```
     * <category term="sports" />
     * <category term="tech" />
     * ```
     * @var array
     */
    public $categories;

//    /**
//     * Names one contributor to the feed. An feed may have multiple contributor elements.
//     * ```
//     * <contributor>
//     *   <name>Jane Doe</name>
//     * </contributor>
//     * ```
//     * @var
//     */
//    public $contributor;

//    /**
//     * Identifies the software used to generate the feed, for debugging and other purposes. Both the uri and version attributes are optional.
//     * ```
//     * <generator uri="/myblog.php" version="1.0">
//     * Example Toolkit
//     * </generator>
//     * ```
//     * @var
//     */
//    public $generator;

    /**
     * Identifies a small image which provides iconic visual identification for the feed. Icons should be square.
     * ```
     * <icon>/icon.jpg</icon>
     * ```
     * @var string
     */
    public $icon;

    /**
     * Identifies a larger image which provides visual identification for the feed. Images should be twice as wide as they are tall.
     * ```
     * <logo>/logo.jpg</logo>
     * ```
     * @var string
     */
    public $logo;

    /**
     * Conveys information about rights, e.g. copyrights, held in and over the feed.
     * ```
     * <rights>© 2005 John Doe</rights>
     * ```
     * @var string
     */
    public $rights;

    /**
     * Contains a human-readable description or subtitle for the feed.
     * ```
     * <subtitle>all your examples are belong to us</subtitle>
     * ```
     * @var string
     */
    public $subtitle;

    /**
     * The entries of the feed.
     * These are all the independent items which are in this particular feed.
     * @var Entry[]
     */
    protected $entries = [];

    /**
     * Feed constructor.
     * @param string $id The unique identifier of the feed
     * @param string $title Title of the feed
     * @param int $updated Last updated time (unix timestamp)
     * @throws FeedException When information given is incorrect
     */
    public function __construct($id, $title, $updated)
    {
        if(empty($id) || empty($title) || !\is_int($updated)) {
            throw new FeedException('Invalid information given');
        }
        $this->id = $id;
        $this->title = $title;
        $this->updated = $updated;
    }

    /**
     * Adds an entry to this feed
     * @param Entry $entry
     */
    public function addEntry(Entry $entry) {
        $this->entries[] = $entry;
    }

    /**
     * Returns the rendered feed object
     * @throws \yii\base\InvalidParamException
     */
    public function render(): string
    {
        $updated = gmdate(DATE_ATOM, $this->updated);
        $this->linkSelf = empty($this->linkSelf) ? Url::to('',true) : $this->linkSelf;
        $feed = <<<FEED
<?xml version="1.0" encoding="utf-8"?>
<feed xmlns="http://www.w3.org/2005/Atom">

    <id>{$this->id}</id>
    <title>{$this->title}</title>
    <updated>{$updated}</updated>
    <link href="{$this->linkSelf}" rel="self" />
FEED;
    $feed .= !empty($this->subtitle) ?    "\n\t<subtitle>{$this->subtitle}</subtitle>" : '';
    $feed .= !empty($this->link) ?        "\n\t<link href=\"{$this->link}\" />" : '';
    $feed .= !empty($this->language) ?    "\n\t<language>{$this->language}</language>" : '';
    $feed .= (!empty($this->author) && !empty($this->authorEmail)) ? "\n\t<author>\n\t\t<name>{$this->author}</name>\n\t\t<email>dev.melle@gmail.com</email>\n\t</author>" : '';
    $feed .= !empty($this->icon) ?        "\n\t<icon>{$this->icon}</icon>" : '';
    foreach($this->categories as $category) {
        if(!empty($category)) {
            $feed .= "\n\t<category term=\"{$category}\"/>";
        }
    }
    $feed .= !empty($this->rights) ?      "\n\t<rights>{$this->rights}</rights>" : '';

    $feed .= "\n\n";

    foreach($this->entries as $entry) {
        $feed .= $entry->render();
    }

    $feed .= "\n</feed>";

    return $feed;
    }

}