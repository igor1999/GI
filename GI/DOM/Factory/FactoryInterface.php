<?php
/*
 * This file is part of PHP-framework GI.
 *
 * PHP-framework GI is free software: you can redistribute it and/or modify
 * it under the terms of the GNU General Public License as published by
 * the Free Software Foundation, either version 3 of the License, or
 * (at your option) any later version.
 *
 * PHP-framework GI is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 * GNU General Public License for more details.
 *
 * You should have received a copy of the GNU General Public License
 * along with PHP-framework GI. If not, see <https://www.gnu.org/licenses/>.
 */
namespace GI\DOM\Factory;

use GI\DOM\Factory\Base\FactoryInterface as BaseInterface;

use GI\DOM\HTML\Element\Input\Factory\FactoryInterface as InputFactoryInterface;

use GI\DOM\Base\Element\Comment\CommentInterface;
use GI\DOM\Base\TextNode\TextNodeInterface;

use GI\DOM\XML\Element\SimpleElementInterface as XMLSimpleElementInterface;
use GI\DOM\XML\Element\ContainerElementInterface as XMLContainerElementInterface;
use GI\DOM\XML\Element\Root\Declaration\DeclarationInterface as XMLDeclarationInterface;
use GI\DOM\XML\Element\Root\RootInterface as XMLRootInterface;
use GI\DOM\XML\Element\Import\ImportInterface as XMLImportInterface;
use GI\DOM\XML\Element\CDATA\CDATAInterface as XMLCDATAInterface;
use GI\DOM\XML\Element\CDATA\CloseDelimiter\CloseDelimiterInterface as XMLCDATACloseDelimiterInterface;

use GI\DOM\HTML\Element\SimpleElementInterface;
use GI\DOM\HTML\Element\ContainerElementInterface;
use GI\DOM\HTML\Element\EmptyElementInterface;

use GI\DOM\HTML\Element\BR\BRInterface;

use GI\DOM\HTML\Element\Button\Button\ButtonInterface;
use GI\DOM\HTML\Element\Button\Reset\ResetInterface;
use GI\DOM\HTML\Element\Button\Submit\SubmitInterface;

use GI\DOM\HTML\Element\Decorator\Big\BigInterface;
use GI\DOM\HTML\Element\Decorator\Bold\BoldInterface;
use GI\DOM\HTML\Element\Decorator\Italic\ItalicInterface;
use GI\DOM\HTML\Element\Decorator\LineThrough\LineThroughInterface;
use GI\DOM\HTML\Element\Decorator\Small\SmallInterface;
use GI\DOM\HTML\Element\Decorator\Strong\StrongInterface;
use GI\DOM\HTML\Element\Decorator\Underline\UnderlineInterface;

use GI\DOM\HTML\Element\Div\DivInterface;
use GI\DOM\HTML\Element\Div\Float\Clear\ClearInterface;
use GI\DOM\HTML\Element\Div\Float\Left\LeftInterface as FloatLeftInterface;
use GI\DOM\HTML\Element\Div\Float\Right\RightInterface as FloatRightInterface;
use GI\DOM\HTML\Element\Div\FloatingLayout\LayoutInterface;
use GI\DOM\HTML\Element\Div\FloatingLayout\Line\LineInterface;

use GI\DOM\HTML\Element\DL\DLInterface;
use GI\DOM\HTML\Element\DL\Items\DT\DTInterface;
use GI\DOM\HTML\Element\DL\Items\DD\DDInterface;

use GI\DOM\HTML\Element\Document\Body\BodyInterface;
use GI\DOM\HTML\Element\Document\Doctype\DoctypeInterface;
use GI\DOM\HTML\Element\Document\DocumentInterface;
use GI\DOM\HTML\Element\Document\Head\HeadInterface;
use GI\DOM\HTML\Element\Document\Title\TitleInterface;
use GI\DOM\HTML\Element\Document\Meta\Charset\CharsetInterface;
use GI\DOM\HTML\Element\Document\Meta\ContentType\ContentTypeInterface;
use GI\DOM\HTML\Element\Document\Meta\MetaInterface;

use GI\DOM\HTML\Element\Form\Fieldset\FieldsetInterface;
use GI\DOM\HTML\Element\Form\Fieldset\Legend\LegendInterface;
use GI\DOM\HTML\Element\Form\FormInterface;
use GI\DOM\HTML\Element\Form\Layouts\Fieldset\FieldsetInterface as FieldsetLayoutInterface;
use GI\DOM\HTML\Element\Form\Layouts\Form\FormInterface as FormLayoutInterface;

use GI\DOM\HTML\Element\Graphic\Canvas\CanvasInterface;

use GI\DOM\HTML\Element\Hyperlink\HyperlinkInterface;

use GI\DOM\HTML\Element\IFrame\IFrameInterface;

use GI\DOM\HTML\Element\Image\ImageInterface;

use GI\DOM\HTML\Element\Link\LinkInterface;
use GI\DOM\HTML\Element\Link\Named\CSS\CSSInterface;
use GI\DOM\HTML\Element\Link\Named\Icon\IconInterface;

use GI\DOM\HTML\Element\Lists\OL\OLInterface;
use GI\DOM\HTML\Element\Lists\UL\ULInterface;
use GI\DOM\HTML\Element\Lists\Items\LI\LIInterface;
use GI\DOM\HTML\Element\Lists\LinkedList\LinkedListInterface;

use GI\DOM\HTML\Element\Script\Extern\ExternInterface;

use GI\DOM\HTML\Element\Script\Inline\InlineInterface;

use GI\DOM\HTML\Element\Select\Optgroup\OptgroupInterface;
use GI\DOM\HTML\Element\Select\Option\OptionInterface;
use GI\DOM\HTML\Element\Select\SelectInterface;

use GI\DOM\HTML\Element\State\Progress\ProgressInterface;
use GI\DOM\HTML\Element\State\Meter\MeterInterface;

use GI\DOM\HTML\Element\Style\Selector\SelectorInterface;
use GI\DOM\HTML\Element\Style\StyleInterface;

use GI\DOM\HTML\Element\Table\Cell\TD\TDInterface;
use GI\DOM\HTML\Element\Table\Cell\TH\THInterface;
use GI\DOM\HTML\Element\Table\Row\TRInterface;
use GI\DOM\HTML\Element\Table\Part\TBody\TBodyInterface;
use GI\DOM\HTML\Element\Table\Part\THead\THeadInterface;
use GI\DOM\HTML\Element\Table\Part\TFooter\TFooterInterface;
use GI\DOM\HTML\Element\Table\TableInterface;

use GI\DOM\HTML\Element\TextArea\TextAreaInterface;

use GI\DOM\HTML\Element\TextContainer\Label\LabelInterface;
use GI\DOM\HTML\Element\TextContainer\Paragraph\ParagraphInterface;
use GI\DOM\HTML\Element\TextContainer\Pre\PreInterface;
use GI\DOM\HTML\Element\TextContainer\Span\SpanInterface;

/**
 * Interface FactoryInterface
 * @package GI\DOM\Factory
 *
 * @method CommentInterface createComment(string $text = '')
 * @method TextNodeInterface createTextNode(string $text = null)
 *
 * @method XMLSimpleElementInterface createXMLSimpleElement(string $tag = '', string $namespace = '')
 * @method XMLContainerElementInterface createXMLContainerElement(string $tag = '', string $namespace = '')
 * @method XMLDeclarationInterface createXMLDeclaration()
 * @method XMLRootInterface createXMLRoot(string $namespace = '')
 * @method XMLImportInterface createXMLImport(string $namespace = '', string $schemaNamespace = '', string $schemaLocation = '')
 * @method XMLCDATAInterface createXMLCDATA(string $text = '')
 * @method XMLCDATACloseDelimiterInterface createXMLCDATACloseDelimiter()
 *
 * @method SimpleElementInterface createSimpleElement(string $tag = '')
 * @method ContainerElementInterface createContainerElement(string $tag = '')
 * @method EmptyElementInterface createEmptyElement(string $tag = '')
 *
 * @method BRInterface createBR()
 *
 * @method ButtonInterface createButton()
 * @method ResetInterface createReset()
 * @method SubmitInterface createSubmit()
 *
 * @method BigInterface createBig(string $text = null)
 * @method BoldInterface createBold(string $text = null)
 * @method ItalicInterface createItalic(string $text = null)
 * @method LineThroughInterface createLineThrough(string $text = null)
 * @method SmallInterface createSmall(string $text = null)
 * @method StrongInterface createStrong(string $text = null)
 * @method UnderlineInterface createUnderline(string $text = null)
 *
 * @method DivInterface createDiv()
 * @method ClearInterface createClear()
 * @method FloatLeftInterface createFloatLeft()
 * @method FloatRightInterface createFloatRight()
 * @method LayoutInterface createLayout()
 * @method LineInterface createLine()
 *
 * @method DLInterface createDL()
 * @method DTInterface createDT(string $text = null)
 * @method DDInterface createDD(string $text = null)
 *
 * @method BodyInterface createBody()
 * @method DoctypeInterface createDoctype(string $text = '')
 * @method DocumentInterface createDocument()
 * @method HeadInterface createHead()
 * @method TitleInterface createTitle(string $text = '')
 * @method CharsetInterface createCharset(string $charset = '')
 * @method ContentTypeInterface createContentType(string $contentType = '')
 * @method MetaInterface createMeta()
 *
 * @method FieldsetInterface createFieldset(string $title = '')
 * @method LegendInterface createLegend(string $title = '')
 * @method FormInterface createForm(string $method = '', string $action = '')
 * @method FormLayoutInterface createFormLayout(string $method = '', string $action = '')
 * @method FieldsetLayoutInterface createFieldsetLayout(string $title = '')
 *
 * @method CanvasInterface createCanvas(string $width, string $height)
 *
 * @method HyperlinkInterface createHyperlink(string $href = '', string $text = '')
 *
 * @method IFrameInterface createIFrame(string $src = '')
 *
 * @method ImageInterface createImage(string $src = '', string $alt = '')
 *
 * @method CSSInterface createCSS(string $href = '')
 * @method IconInterface createIcon(string $href = '')
 * @method LinkInterface createLink(string $href = '', string $rel = '', string $type = '')
 *
 * @method OLInterface createOL()
 * @method ULInterface createUL()
 * @method LIInterface createLI(string $text = null)
 * @method LinkedListInterface createLinkedList(array $source)
 *
 * @method ProgressInterface createProgress()
 * @method MeterInterface createMeter(int $value)
 *
 * @method ExternInterface createExternScript(string $src = '')
 *
 * @method InlineInterface createInlineScript(string $text = '')
 *
 * @method OptgroupInterface createOptgroup(string $label = '')
 * @method OptionInterface createOption($value = '', string $text = null, bool $selected = false)
 * @method SelectInterface createSelect()
 *
 * @method SelectorInterface createSelector(string $selector, array $attributes = [])
 * @method StyleInterface createStyle()
 *
 * @method TDInterface createTD(string $text = null)
 * @method THInterface createTH(string $text = null)
 * @method TRInterface createTR()
 * @method TBodyInterface createTBody()
 * @method THeadInterface createTHead()
 * @method TFooterInterface createTFooter()
 * @method TableInterface createTable()
 *
 * @method TextAreaInterface createTextArea(array $name = [], string $text = null)
 *
 * @method LabelInterface createLabel(string $text = null)
 * @method ParagraphInterface createParagraph(string $text = null)
 * @method PreInterface createPre(string $text = null)
 * @method SpanInterface createSpan(string $text = null)
 */
interface FactoryInterface extends BaseInterface
{
    /**
     * @return InputFactoryInterface
     */
    public function getInputFactory();
}