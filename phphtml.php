<?php

/**
 * :))
 */

abstract class DOMObject
{
    public $classes = [];
    public $name;
    public $id;

    protected $elems = [];
    protected $identity = 'div';


    public function add(string $object)
    {
        $object = ucfirst($object);

        if (class_exists($object)) {
            return $this->elems[] = new $object();
        }

        $html = <<<_END
<div style="font-size: 40px; border-radius: .3rem; border: solid 2px red; padding: .5rem;">
    Nie znaleziono elementu: <span style="text-decoration:underline;">{$object}</span>
</div>
_END;
        $div = new Div();
        $div->text($html);

        return $this->elems[] = $div;
    }

    public function text(string $text)
    {
        $this->elems[] = new Text($text);

        return $this;
    }

    public function addClass(string $class)
    {
        if (!in_array($class, $this->classes)) {
            $this->classes[] = $class;
        }

        return $this;
    }

    public function name(string $name)
    {
        $this->name = $name;

        return $this;
    }

    public function id(string $id)
    {
        $this->id = $id;

        return $this;
    }

    public function __toString()
    {
        $html = "<{$this->identity}";

        if (!empty($this->classes)) {
            $html .= sprintf(' class="%s"', implode(' ', $this->classes));
        }

        if (!empty($this->name)) {
            $html .= " name=\"{$this->name}\"";
        }

        if (!empty($this->id)) {
            $html .= " id=\"{$this->id}\"";
        }

        $html .= '>' . PHP_EOL;
        
        foreach ($this->elems as $elem) {
            $html.= "{$elem}";
        }

        $html .= PHP_EOL . "</{$this->identity}>" . PHP_EOL;

        return $html;
    }
}

class Text
{
    public $text;


    public function __construct(string $text)
    {
        $this->text = $text;
    }

    public function __toString()
    {
        return $this->text;
    }
}

class Html extends DOMObject
{
    public $head;
    public $body;

    protected $identity = 'html';


    public function __construct(Head &$head, Body &$body)
    {
        $this->head =& $head;
        $this->body =& $body;
    }

    public function __destruct()
    {
        $html = '<!doctype html>' . PHP_EOL;
        $html .= "<{$this->identity}";

        if (!empty($this->classes)) {
            $html .= sprintf(' class="%s"', implode(' ', $this->classes));
        }

        if (!empty($this->name)) {
            $html .= " name=\"{$this->name}\"";
        }

        if (!empty($this->id)) {
            $html .= " id=\"{$this->id}\"";
        }

        $html .= '>' . PHP_EOL;

        $html .= $this->head;
        $html .= $this->body;
        $html .= '<!-- Plik HTML wygenerowany za pomocą ... XD -->' . PHP_EOL;
        $html .= '</html>' . PHP_EOL;

        echo $html;
    }
}

class Head
{
    public $stylesheets = [];
    public $style = '';
    public $metas = [];
    public $title = "\t<title>Hello World!</title>" . PHP_EOL;


    public function style(string $style)
    {
        $this->style = "<style>{$style}</style>";
    }

    public function stylesheet(string $url)
    {
        $this->stylesheets[] = "\t<link rel=\"stylesheet\" href=\"{$url}\">" . PHP_EOL;

        return $this;
    }

    public function meta(string $name, string $args)
    {
        $this->metas[] = "\t<meta name=\"{$name}\" content=\"{$args}\">" . PHP_EOL;

        return $this;
    }

    public function charset(string $charset)
    {
        $this->metas[] = "\t<meta charset=\"{$charset}\">" . PHP_EOL;

        return $this;
    }

    public function title(string $title)
    {
        $this->title = "\t<title>{$title}</title>" . PHP_EOL;

        return $this;
    }

    public function __toString()
    {
        $html = '<head>' . PHP_EOL;
        $html .= $this->title;
        $html .= implode($this->metas);
        $html .= implode($this->stylesheets);
        $html .= $this->style;
        $html .= '</head>' . PHP_EOL;

        return $html;
    }
}

class Body extends DOMObject
{
    protected $identity = 'body';
}


class Div extends DOMObject 
{
    protected $identity = 'div';
}
class Header extends DOMObject 
{
    protected $identity = 'header';
}
class Footer extends DOMObject
{
    protected $identity = 'footer';
}
class Main extends DOMObject 
{
    protected $identity = 'main';
}
class Article extends DOMObject
{
    protected $identity = 'article';
}
class Nav extends DOMObject 
{
    protected $identity = 'nav';
}
class Section extends DOMObject 
{
    protected $identity = 'section';
}
class Ul extends DOMObject
{
    protected $identity = 'ul';
}
class Li extends DOMObject
{
    protected $identity = 'li';
}
class Ol extends DOMObject
{
    protected $identity = 'ol';
}
class P extends DOMObject
{
    protected $identity = 'p';
}
class H1 extends DOMObject
{
    protected $identity = 'h1';
}
class H2 extends DOMObject
{
    protected $identity = 'h2';
}
class H3 extends DOMObject
{
    protected $identity = 'h3';
}
class H4 extends DOMObject
{
    protected $identity = 'h4';
}
class H5 extends DOMObject
{
    protected $identity = 'h5';
}
class H6 extends DOMObject
{
    protected $identity = 'h6';
}

class A extends DOMObject
{
    protected $identity = 'a';
    public $href = '#';


    public function href(string $href)
    {
        $this->href = $href;

        return $this;
    }

    public function __toString()
    {
        $html = sprintf('<%s href="%s"', $this->identity, $this->href);

        if (!empty($this->classes)) {
            $html .= sprintf(' class="%s"', implode(" ", $this->classes));
        }

        $html .= ">" . PHP_EOL;        

        foreach ($this->elems as $elem) {
            $html.= $elem . PHP_EOL;
        }

        $html .= "</{$this->identity}>" . PHP_EOL;

        return $html;
    }
}

$head = new Head();
$body = new Body();
$html = new Html($head, $body);
