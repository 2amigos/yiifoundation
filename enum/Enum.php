<?php
/**
 * @copyright Copyright &copy; 2amigOS! Consulting Group 2013-
 * @license http://www.opensource.org/licenses/bsd-license.php New BSD License
 * @package foundation.components
 * @version 1.0.0
 */
namespace foundation\enum;

/**
 * Enum holds most of the Foundation classes
 *
 * @see http://foundation.zurb.com/docs/
 *
 * @author Antonio Ramirez <amigo.cobos@gmail.com>
 * @package foundation\enum
 */
class Enum
{
    // Id prefix
    const ID_PREFIX = 'yf';

    // Breadcrumbs
    const BREADCRUMBS = 'breadcrumbs';

    // Pagination classes
    const PAGINATION          = 'pagination';
    const PAGINATION_CENTERED = 'pagination-centered';

    // Switch button
    const SWITCH_BUTTON = 'switch';

    // Size classes
    const SIZE_TINY   = 'tiny';
    const SIZE_SMALL  = 'small';
    const SIZE_MEDIUM = 'medium';
    const SIZE_LARGE  = 'large';
    const SIZE_EXPAND = 'expand';

    // Color classes
    const COLOR_REGULAR   = 'regular';
    const COLOR_SECONDARY = 'secondary';
    const COLOR_ALERT     = 'alert';
    const COLOR_SUCCESS   = 'success';

    // Radius classes
    const RADIUS_RADIUS = 'radius';
    const RADIUS_ROUND  = 'round';

    // Dropdown classes
    const DROPDOWN         = 'dropdown';
    const DROPDOWN_LIST    = 'f-dropdown';
    const DROPDOWN_CONTENT = 'f-dropdown content';
    const DROPDOWN_SPLIT   = 'split';
    const DROPDOWN_HAS     = 'has-dropdown';
    const CONTENT          = 'content';

    // Panel
    const PANEL         = 'panel';
    const PANEL_CALLOUT = 'callout';

    // Clearing
    const CLEARING_THUMBS      = 'clearing-thumbs';
    const ClEARING_FEATURE     = 'clearing-feature';
    const CLEARING_FEATURE_IMG = 'clearing-feature-img';

    // JoyRide
    const JOYRIDE_LIST = 'joyride-list';

    // Pricing Table
    const PRICING_TABLE = 'pricing-table';

    // Progress
    const PROGRESS       = 'progress';
    const PROGRESS_METER = 'meter';

    // Even classes
    // @see http://foundation.zurb.com/docs/components/button-groups.html
    const EVEN_2 = 'even-2';
    const EVEN_3 = 'even-3';
    const EVEN_4 = 'even-4';
    const EVEN_5 = 'even-5';
    const EVEN_6 = 'even-6';
    const EVEN_7 = 'even-7';
    const EVEN_8 = 'even-8';

    // State classes
    const STATE_DISABLED = 'disabled';
    const STATE_ACTIVE   = 'active';

    // Position classes
    const POS_RIGHT = 'right';
    const POS_LEFT  = 'left';

    // nav classes
    const NAV_SIDE      = 'side-nav';
    const NAV_DIVIDER   = 'divider';
    const NAV_SUB       = 'sub-nav';
    const NAV_TOPBAR    = 'top-bar';
    const NAV_FIXED     = 'fixed';
    const NAV_STICKY    = 'sticky';
    const NAV_CONTAINED = 'contain-to-grid';

    // video classes
    const VIDEO_FLEXVIDEO  = 'flex-video';
    const VIDEO_WIDESCREEN = 'widescreen';
    const VIDEO_VIMEO      = 'vimeo';

    // slideshow classes
    const ORBIT_WRAPPER = 'slideshow-wrapper';
    const ORBIT_LOADER  = 'preloader';
    const ORBIT_CAPTION = 'orbit-caption';

    // dialog classes
    const DIALOG       = 'reveal-modal';
    const DIALOG_CLOSE = 'close-reveal-modal';
    // dialog sizes
    // sets the width to 30%
    const DIALOG_SMALL = 'small';
    // sets the width to 40%
    const DIALOG_MEDIUM = 'medium';
    // sets the width to 60%
    const DIALOG_LARGE = 'large';
    // sets the width to 70%
    const DIALOG_XLARGE = 'xlarge';
    // sets the width to 95%
    const DIALOG_EXPAND = 'expand';

    // section classes
    const SECTION_CONTAINER            = 'section-container';
    const SECTION_STYLE_AUTO           = 'auto';
    const SECTION_STYLE_TABS           = 'tabs';
    const SECTION_STYLE_VERTICAL_TABS  = 'vertical-tabs';
    const SECTION_STYLE_ACCORDION      = 'accordion';
    const SECTION_STYLE_VERTICAL_NAV   = 'vertical-nav';
    const SECTION_STYLE_HORIZONTAL_NAV = 'horizontal-nav';

    // tooltip classes
    const TOOLTIP        = 'has-tip';
    const TOOLTIP_TOP    = 'tip-top';
    const TOOLTIP_BOTTOM = 'tip-bottom';
    const TOOLTIP_LEFT   = 'tip-left';
    const TOOLTIP_RIGHT  = 'tip-right';

    // Foundation Icons
    // Social Elements
    const ICON_THUMBS_UP    = 'thumb-up';
    const ICON_THUMB_DOWN   = 'thumb-down';
    const ICON_RSS          = 'rss';
    const ICON_FACEBOOK     = 'facebook';
    const ICON_TWITTER      = 'twitter';
    const ICON_PINTEREST    = 'pinteres';
    const ICON_GITHUB       = 'github';
    const ICON_PATH         = 'path';
    const ICON_LINKEDIN     = 'linkedin';
    const ICON_DRIBBLE      = 'dribble';
    const ICON_STUMBLE_UPON = 'stumble-upon';
    const ICON_BEHANCE      = 'behance';
    const ICON_REDDIT       = 'reddit';
    const ICON_GOOGLE_PLUS  = 'google-plus';
    const ICON_YOUTUBE      = 'youtube';
    const ICON_VIMEO        = 'vimeo';
    const ICON_FLICKR       = 'flickr';
    const ICON_SLIDESHARE   = 'slideshare';
    const ICON_PICASSA      = 'picassa';
    const ICON_SKYPE        = 'skype';
    const ICON_INSTAGRAM    = 'instagram';
    const ICON_FOURSQUARE   = 'foursquare';
    const ICON_DELICIOUS    = 'delicious';
    const ICON_CHAT         = 'chat';
    const ICON_TORSO        = 'toro';
    const ICON_TUMBLR       = 'tumblr';
    const ICON_VIDEO_CHAT   = 'video-chat';
    const ICON_DIGG         = 'digg';
    const ICON_WORDPRESS    = 'wordpress';

    // Accessibility Elements
    const ICON_WHEELCHAIR       = 'wheelchair';
    const ICON_SPEAKER          = 'speaker';
    const ICON_FONTSIZE         = 'fontsize';
    const ICON_EJECT            = 'eject';
    const ICON_VIEW_MODE        = 'view-mode';
    const ICON_EYEBALL          = 'eyeball';
    const ICON_ASL              = 'asl';
    const ICON_PERSON           = 'person';
    const ICON_QUESTION         = 'question';
    const ICON_ADULT            = 'adult';
    const ICON_CHILD            = 'child';
    const ICON_GLASSES          = 'glasses';
    const ICON_CC               = 'cc';
    const ICON_BLIND            = 'blind';
    const ICON_BRAILLE          = 'braille';
    const ICON_IPHONE_HOME      = 'iphone-hone';
    const ICON_W3C              = 'w3c';
    const ICON_CSS              = 'css';
    const ICON_KEY              = 'key';
    const ICON_HEARING_IMPAIRED = 'hearing-impaired';
    const ICON_MALE             = 'male';
    const ICON_FEMAILE          = 'female';
    const ICON_NETWORK          = 'network';
    const ICON_GUIDEDOG         = 'guidedog';
    const ICON_UNIVERSAL_ACCESS = 'universal-access';
    const ICON_ELEVATOR         = 'elevator';

    // General [ used with closed or not closed style fonts]
    const ICON_SETTINGS     = 'settings';
    const ICON_HEART        = 'heart';
    const ICON_STAR         = 'star';
    const ICON_PLUS         = 'plus';
    const ICON_MINUS        = 'minus';
    const ICON_CHECKMARK    = 'checkmark';
    const ICON_REMOVE       = 'remove';
    const ICON_MAIL         = 'mail';
    const ICON_CALENDAR     = 'calendar';
    const ICON_PAGE         = 'page';
    const ICON_TOOLS        = 'tools';
    const ICON_GLOBE        = 'globe';
    const ICON_HOME         = 'home';
    const ICON_QUOTE        = 'quote';
    const ICON_PEOPLE       = 'people';
    const ICON_MONITOR      = 'monitor';
    const ICON_LAPTOP       = 'laptop';
    const ICON_PHONE        = 'phone';
    const ICON_CLOUD        = 'cloud';
    const ICON_ERROR        = 'error';
    const ICON_RIGHT_ARROW  = 'right-arrow';
    const ICON_LEFT_ARROW   = 'left-arrow';
    const ICON_UP_ARROW     = 'up-arrow';
    const ICON_DOWN_ARROW   = 'down-arrow';
    const ICON_TRASH        = 'trash';
    const ICON_ADD_DOC      = 'add-doc';
    const ICON_EDIT         = 'edit';
    const ICON_LOCK         = 'lock';
    const ICON_UNLOCK       = 'unlock';
    const ICON_REFRESH      = 'refresh';
    const ICON_PAPER_CLIP   = 'paper-clip';
    const ICON_VIDEO        = 'video';
    const ICON_PHOTO        = 'photo';
    const ICON_GRAPH        = 'graph';
    const ICON_IDEA         = 'idea';
    const ICON_MIC          = 'mic';
    const ICON_CART         = 'cart';
    const ICON_ADDRESS_BOOK = 'address-book';
    const ICON_COMPASS      = 'compass';
    const ICON_FLAG         = 'flag';
    const ICON_LOCATION     = 'location';
    const ICON_CLOCK        = 'clock';
    const ICON_FOLDER       = 'folder';
    const ICON_INBOX        = 'inbox';
    const ICON_WEBSITE      = 'website';
    const ICON_SMILEY       = 'smiley';
    const ICON_SEARCH       = 'search';

    // Available icon fonts
    const ICONS_SET_ACCESSIBILITY    = 'accessibility';
    const ICONS_SET_GENERAL          = 'general';
    const ICONS_SET_GENERAL_ENCLOSED = 'general_enclosed';
    const ICONS_SET_SOCIAL           = 'social';
}