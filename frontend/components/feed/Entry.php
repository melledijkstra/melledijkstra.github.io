<?php
/**
 * Created by PhpStorm.
 * User: Melle Dijkstra
 * Date: 7-3-2017
 * Time: 16:35
 */

namespace frontend\components\feed;

/**
 * Class Entry to create a Atom RSS entry which can be added to Feed object
 * @package frontend\components\feed
 * @see https://validator.w3.org/feed/docs/atom.html
 */
class Entry
{
    /**
     * Identifies the entry using a universally unique and permanent URI.
     * Suggestions on how to make a good id can be found here.
     * Two entries in a feed can have the same value for id if they represent the same entry at different points in time.
     * ```
     * <id>http://example.com/blog/1234</id>
     * ```
     * @var string
     */
    public $id;

    /**
     * Contains a human readable title for the entry.
     * This value should not be blank.
     * ```
     * <title>Atom-Powered Robots Run Amok</title>
     * ```
     * @var string
     */
    public $title;

    /**
     * Indicates the last time the entry was modified in a significant way.
     * This value need not change after a typo is fixed, only after a substantial modification.
     * Generally, different entries in a feed will have different updated timestamps.
     * ```
     * <updated>2003-12-13T18:30:02-05:00</updated>
     * ```
     * Can be either unix timestamp DateTime object or a string which can be formatted
     * @var int|\DateTime|string
     */
    public $updated;

    /**
     * Names one author of the entry.
     * An entry may have multiple authors.
     * An entry must contain at least one author element unless there is an author element in the enclosing feed, or there is an author element in the enclosed source element.
     * ```
     * <author>
     *      <name>John Doe</name>
     * </author>
     * ```
     * @var
     */
    public $author;

    /**
     * Contains or links to the complete content of the entry.
     * Content must be provided if there is no alternate link, and should be provided if there is no summary.
     * ```
     * <content>complete story here</content>
     * ```
     * @var string
     */
    public $content;

    /**
     * Identifies a related Web page.
     * The type of relation is defined by the rel attribute.
     * An entry is limited to one alternate per type and hreflang.
     * An entry must contain an alternate link if there is no content element.
     * ```
     * <link rel="alternate" href="/blog/1234"/>
     * ```
     * @var string
     */
    public $link;

    /**
     * Conveys a short summary, abstract, or excerpt of the entry.
     * Summary should be provided if there either is no content provided for the entry, or that content is not inline (i.e., contains a src attribute), or if the content is encoded in base64.
     * ```
     * <summary>Some text.</summary>
     * ```
     * @var string
     */
    public $summary;

    /**
     * Specifies a category that the entry belongs to. An entry may have multiple category elements.
     *
     * example: ['sports', 'tech']
     * will generate:
     * ```
     * <category term="sports" />
     * <category term="tech" />
     * ```
     * @var array
     */
    public $categories = [];

    /**
     * Name contributor to the entry.
     * ```
     * <contributor>
     *      <name>Jane Doe</name>
     * </contributor>
     * ```
     * @var string
     */
    public $contributor;

    /**
     * Contains the time of the initial creation or first availability of the entry.
     * ```
     * <published>2003-12-13T09:17:51-08:00</published>
     * ```
     * @var
     */
    public $published;

    /**
     * Identifies a small image which provides iconic visual identification for the feed.
     * Icons should be square.
     * ```
     * <icon>/icon.jpg</icon>
     * ```
     * @var string
     */
    public $icon;

    /**
     * Identifies a larger image which provides visual identification for the feed.
     * Images should be twice as wide as they are tall.
     * ```
     * <logo>/logo.jpg</logo>
     * ```
     * @var string
     */
    public $logo;

    /**
     * Conveys information about rights, e.g. copyrights, held in and over the entry.
     * ```
     * <rights type="html">
     *  &amp;copy; 2005 John Doe
     * </rights>
     * ```
     * @var
     */
    public $rights;

//    /**
//     * Contains metadata from the source feed if this entry is a copy.
//     * <source>
//     *      <id>http://example.org/</id>
//     *      <title>Example, Inc.</title>
//     *      <updated>2003-12-13T18:30:02Z</updated>
//     * </source>
//     * @var array
//     */
//    public $source;

    /**
     * Entry constructor.
     * @param string $id
     * @param string $title
     * @param int $updated (unix timestamp)
     * @throws FeedException When information given is incorrect
     */
    public function __construct($id, $title, $updated)
    {
        if (empty($id) || empty($title) || !is_int($updated)) throw new FeedException('Invalid information given');
        $this->id = $id;
        $this->title = $title;
        $this->updated = $updated;
    }

    /**
     * Returns the rendered entry object
     */
    public function render()
    {
        $updated = gmdate(DATE_ATOM, $this->updated);
        $entry = <<<ENTRY
    \n\t<entry>
        <id>{$this->id}</id>
        <title>{$this->title}</title>
        <updated>{$updated}</updated>
ENTRY;
        $entry .= (!empty($this->summary)) ? "\n\t\t<summary>{$this->summary}</summary>" : '';
        $entry .= (!empty($this->published)) ? "\n\t\t<published>" . gmdate(DATE_ATOM, $this->published) . "</published>" : '';
        $entry .= (!empty($this->link)) ? "\n\t\t<link href=\"{$this->link}\" rel=\"alternate\" />" : '';
        $entry .= (!empty($this->author)) ? "\n\t\t<author>\n\t\t\t<name>{$this->author}</name>\n\t\t</author>" : '';
        $entry .= (!empty($this->icon)) ? "\n\t\t<icon>{$this->icon}</icon>" : '';
        $entry .= (!empty($this->logo)) ? "\n\t\t<logo>{$this->logo}</logo>" : '';
        foreach ($this->categories as $category) {
            if (!empty($category)) $entry .= "\n\t\t<category term=\"{$category}\"/>";
        }
        $entry .= (!empty($this->content)) ? "\n\t\t<content type=\"html\">" . htmlspecialchars($this->content, ENT_QUOTES, 'utf-8') . "</content>" : '';

        $entry .= "\n\t</entry>";
        return $entry;

    }

}