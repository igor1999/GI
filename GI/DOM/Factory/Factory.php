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

use GI\DOM\Factory\Base\AbstractFactory;

use GI\DOM\HTML\Element\Input\Factory\Factory as InputFactory;

use GI\DOM\Base\Element\Comment\Comment;
use GI\DOM\Base\TextNode\TextNode;

use GI\DOM\XML\Element\SimpleElement as XMLSimpleElement;
use GI\DOM\XML\Element\ContainerElement as XMLContainerElement;
use GI\DOM\XML\Element\Root\Declaration\Declaration as XMLDeclaration;
use GI\DOM\XML\Element\Root\Root as XMLRoot;
use GI\DOM\XML\Element\Import\Import as XMLImport;
use GI\DOM\XML\Element\CDATA\CDATA as XMLCDATA;
use GI\DOM\XML\Element\CDATA\CloseDelimiter\CloseDelimiter as XMLCDATACloseDelimiter;

use GI\DOM\HTML\Element\SimpleElement;
use GI\DOM\HTML\Element\ContainerElement;
use GI\DOM\HTML\Element\EmptyElement;

use GI\DOM\HTML\Element\BR\BR;

use GI\DOM\HTML\Element\Button\Button\Button;
use GI\DOM\HTML\Element\Button\Reset\Reset;
use GI\DOM\HTML\Element\Button\Submit\Submit;

use GI\DOM\HTML\Element\Decorator\Big\Big;
use GI\DOM\HTML\Element\Decorator\Bold\Bold;
use GI\DOM\HTML\Element\Decorator\Italic\Italic;
use GI\DOM\HTML\Element\Decorator\LineThrough\LineThrough;
use GI\DOM\HTML\Element\Decorator\Small\Small;
use GI\DOM\HTML\Element\Decorator\Strong\Strong;
use GI\DOM\HTML\Element\Decorator\Underline\Underline;

use GI\DOM\HTML\Element\Div\Div;
use GI\DOM\HTML\Element\Div\Float\Clear\Clear;
use GI\DOM\HTML\Element\Div\Float\Left\Left as FloatLeft;
use GI\DOM\HTML\Element\Div\Float\Right\Right as FloatRight;
use GI\DOM\HTML\Element\Div\FloatingLayout\Layout;
use GI\DOM\HTML\Element\Div\FloatingLayout\Line\Line;

use GI\DOM\HTML\Element\DL\DL;
use GI\DOM\HTML\Element\DL\Items\DT\DT;
use GI\DOM\HTML\Element\DL\Items\DD\DD;

use GI\DOM\HTML\Element\Document\Body\Body;
use GI\DOM\HTML\Element\Document\Doctype\Doctype;
use GI\DOM\HTML\Element\Document\Document;
use GI\DOM\HTML\Element\Document\Head\Head;
use GI\DOM\HTML\Element\Document\Title\Title;
use GI\DOM\HTML\Element\Document\Meta\Charset\Charset;
use GI\DOM\HTML\Element\Document\Meta\ContentType\ContentType;
use GI\DOM\HTML\Element\Document\Meta\Meta;

use GI\DOM\HTML\Element\Form\Fieldset\Fieldset;
use GI\DOM\HTML\Element\Form\Fieldset\Legend\Legend;
use GI\DOM\HTML\Element\Form\Form;
use GI\DOM\HTML\Element\Form\Layouts\Fieldset\Fieldset as FieldsetLayout;
use GI\DOM\HTML\Element\Form\Layouts\Form\Form as FormLayout;

use GI\DOM\HTML\Element\Graphic\Canvas\Canvas;

use GI\DOM\HTML\Element\Hyperlink\Hyperlink;

use GI\DOM\HTML\Element\IFrame\IFrame;

use GI\DOM\HTML\Element\Image\Image;

use GI\DOM\HTML\Element\Link\Link;
use GI\DOM\HTML\Element\Link\Named\CSS\CSS;
use GI\DOM\HTML\Element\Link\Named\Icon\Icon;

use GI\DOM\HTML\Element\Lists\OL\OL;
use GI\DOM\HTML\Element\Lists\UL\UL;
use GI\DOM\HTML\Element\Lists\Items\LI\LI;
use GI\DOM\HTML\Element\Lists\Tree\Tree;
use GI\DOM\HTML\Element\Lists\LinkedList\LinkedList;

use GI\DOM\HTML\Element\Script\Extern\Extern;

use GI\DOM\HTML\Element\Script\Inline\Inline;

use GI\DOM\HTML\Element\Select\Optgroup\Optgroup;
use GI\DOM\HTML\Element\Select\Option\Option;
use GI\DOM\HTML\Element\Select\Select;

use GI\DOM\HTML\Element\State\Progress\Progress;
use GI\DOM\HTML\Element\State\Meter\Meter;

use GI\DOM\HTML\Element\Style\Selector\Selector;
use GI\DOM\HTML\Element\Style\Style;

use GI\DOM\HTML\Element\Table\Cell\TD\TD;
use GI\DOM\HTML\Element\Table\Cell\TH\TH;
use GI\DOM\HTML\Element\Table\Row\TR;
use GI\DOM\HTML\Element\Table\Part\TBody\TBody;
use GI\DOM\HTML\Element\Table\Part\THead\THead;
use GI\DOM\HTML\Element\Table\Part\TFooter\TFooter;
use GI\DOM\HTML\Element\Table\Table;

use GI\DOM\HTML\Element\TextArea\TextArea;

use GI\DOM\HTML\Element\TextContainer\Label\Label;
use GI\DOM\HTML\Element\TextContainer\Paragraph\Paragraph;
use GI\DOM\HTML\Element\TextContainer\Pre\Pre;
use GI\DOM\HTML\Element\TextContainer\Span\Span;


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
use GI\DOM\HTML\Element\Lists\Tree\TreeInterface;
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

use GI\Storage\Tree\TreeInterface as SourceTreeInterface;

/**
 * Class Factory
 * @package GI\DOM\Factory
 *
 * @method CommentInterface createComment(string $text = '')
 * @method TextNodeInterface createTextNode(string $text = '')
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
 * @method BigInterface createBig(string $text = '')
 * @method BoldInterface createBold(string $text = '')
 * @method ItalicInterface createItalic(string $text = '')
 * @method LineThroughInterface createLineThrough(string $text = '')
 * @method SmallInterface createSmall(string $text = '')
 * @method StrongInterface createStrong(string $text = '')
 * @method UnderlineInterface createUnderline(string $text = '')
 *
 * @method DivInterface createDiv()
 * @method ClearInterface createClear()
 * @method FloatLeftInterface createFloatLeft()
 * @method FloatRightInterface createFloatRight()
 * @method LayoutInterface createLayout()
 * @method LineInterface createLine()
 *
 * @method DLInterface createDL()
 * @method DTInterface createDT(string $text = '')
 * @method DDInterface createDD(string $text = '')
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
 * @method LIInterface createLI(string $text = '')
 * @method TreeInterface createTree(SourceTreeInterface $source, string $parentKey = '')
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
 * @method OptionInterface createOption($value = '', string $text = '', bool $selected = false)
 * @method SelectInterface createSelect()
 *
 * @method SelectorInterface createSelector(string $selector, array $attributes = [])
 * @method StyleInterface createStyle()
 *
 * @method TDInterface createTD(string $text = '')
 * @method THInterface createTH(string $text = '')
 * @method TRInterface createTR()
 * @method TBodyInterface createTBody()
 * @method THeadInterface createTHead()
 * @method TFooterInterface createTFooter()
 * @method TableInterface createTable()
 *
 * @method TextAreaInterface createTextArea(array $name = [], string $text = '')
 *
 * @method LabelInterface createLabel(string $text = '')
 * @method ParagraphInterface createParagraph(string $text = '')
 * @method PreInterface createPre(string $text = '')
 * @method SpanInterface createSpan(string $text = '')
 */
class Factory extends AbstractFactory implements FactoryInterface
{
    /**
     * @var InputFactoryInterface
     */
    private $inputFactory;


    /**
     * Factory constructor.
     * @throws \Exception
     */
    public function __construct()
    {
        parent::__construct();

        $this->set(Comment::class)
            ->set(TextNode::class, null, false)

            ->setNamed('XMLSimpleElement',XMLSimpleElement::class)
            ->setNamed('XMLContainerElement',XMLContainerElement::class)
            ->setNamed('XMLDeclaration',XMLDeclaration::class)
            ->setNamed('XMLRoot',XMLRoot::class)
            ->setNamed('XMLImport',XMLImport::class)
            ->setNamed('XMLCDATA',XMLCDATA::class)
            ->setNamed('XMLCDATACloseDelimiter',XMLCDATACloseDelimiter::class, null, false)

            ->set(SimpleElement::class)
            ->set(ContainerElement::class)
            ->set(EmptyElement::class)

            ->set(BR::class)

            ->set(Button::class)
            ->set(Reset::class)
            ->set(Submit::class)

            ->set(Big::class)
            ->set(Bold::class)
            ->set(Italic::class)
            ->set(LineThrough::class)
            ->set(Small::class)
            ->set(Strong::class)
            ->set(Underline::class)

            ->set(Div::class)
            ->set(Clear::class)
            ->setNamed('FloatLeft', FloatLeft::class)
            ->setNamed('FloatRight', FloatRight::class)
            ->set(Layout::class)
            ->set(Line::class)

            ->set(DL::class)
            ->set(DT::class)
            ->set(DD::class)

            ->set(Body::class)
            ->set(Doctype::class)
            ->set(Document::class)
            ->set(Head::class)
            ->set(Title::class)
            ->set(Charset::class)
            ->set(ContentType::class)
            ->set(Meta::class)

            ->set(Fieldset::class)
            ->set(Legend::class)
            ->set(Form::class)
            ->setNamed('FormLayout', FormLayout::class)
            ->setNamed('FieldsetLayout', FieldsetLayout::class)

            ->set(Canvas::class)

            ->set(Hyperlink::class)

            ->set(IFrame::class)

            ->set(Image::class)

            ->set(Link::class)
            ->set(CSS::class)
            ->set(Icon::class)

            ->set(OL::class)
            ->set(UL::class)
            ->set(LI::class)
            ->set(Tree::class)
            ->set(LinkedList::class)

            ->setNamed('ExternScript', Extern::class)

            ->setNamed('InlineScript', Inline::class)

            ->set(Optgroup::class)
            ->set(Option::class)
            ->set(Select::class)

            ->set(Progress::class)
            ->set(Meter::class)

            ->set(Selector::class, null, false)
            ->set(Style::class)

            ->set(TD::class)
            ->set(TH::class)
            ->set(TR::class)
            ->set(TBody::class)
            ->set(THead::class)
            ->set(TFooter::class)
            ->set(Table::class)

            ->set(TextArea::class)

            ->set(Label::class)
            ->set(Paragraph::class)
            ->set(Pre::class)
            ->set(Span::class)
        ;
    }

    /**
     * @return InputFactoryInterface
     */
    public function getInputFactory()
    {
        if (!($this->inputFactory instanceof InputFactoryInterface)) {
            $this->inputFactory = new InputFactory();
        }

        return $this->inputFactory;
    }
}