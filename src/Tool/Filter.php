<?php

namespace KLib2\Tool;

class Filter 
{
    public const G = 'get';
    public const P = 'post';
    public const F = 'file';

    private array $get;
    private array $post;

    private array $file;

    public function __construct()
    {
        $this->get = $this->clean(self::G);
        $this->post = $this->clean(self::P);
        $this->file = $this->clean(self::F);
    }

    public function clean($sg = 'get', $data = null) {

        if ($data === null) {
            switch ($sg) {
                case self::G:
                    $data = $_GET;
                    break;
                case self::P:
                    $data = $_POST;
                    break;
                case self::F:
                    $data = $_FILES;
                    break;
                default:
                    return null;
            }
        }

        return $data;
    }

	/**
	 * @return array
	 */
	public function getGet(): array {
		return $this->get;
	}

	/**
	 * @return array
	 */
	public function getPost(): array {
		return $this->post;
	}

	/**
	 * @return array
	 */
	public function getFile(): array {
		return $this->file;
	}

}