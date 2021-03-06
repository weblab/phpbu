<?php
namespace phpbu\App\Backup;

/**
 * Cli Test
 *
 * @package    phpbu
 * @subpackage tests
 * @author     Sebastian Feldmann <sebastian@phpbu.de>
 * @copyright  Sebastian Feldmann <sebastian@phpbu.de>
 * @license    http://www.opensource.org/licenses/BSD-3-Clause  The BSD 3-Clause License
 * @link       http://www.phpbu.de/
 * @since      Class available since Release 2.1.0
 */
abstract class CliTest extends \PHPUnit_Framework_TestCase
{
    /**
     * Path to fake binaries.
     *
     * @var string
     */
    protected $binDir;

    /**
     * BinDir getter.
     *
     * @return string
     */
    public function getBinDir()
    {
        if (empty($this->binDir)) {
            $this->binDir = realpath(__DIR__ . '/../../_files/bin');
        }
        return $this->binDir;
    }

    /**
     * Create App\Result mock.
     *
     * @return \phpbu\App\Result
     */
    protected function getAppResultMock()
    {
        return $this->getMockBuilder('\\phpbu\\App\\Result')->disableOriginalConstructor()->getMock();
    }

    /**
     * Create Cli\Result mock.
     *
     * @param  integer $code
     * @param  string  $cmd
     * @return \phpbu\App\Cli\Result
     */
    protected function getCliResultMock($code, $cmd)
    {
        $cliResult = $this->getMockBuilder('\\phpbu\\App\\Cli\\Result')
                          ->disableOriginalConstructor()
                          ->getMock();

        $cliResult->method('getCode')->willReturn($code);
        $cliResult->method('getCmd')->willReturn($cmd);
        $cliResult->method('getOutput')->willReturn(array());
        $cliResult->method('wasSuccessful')->willReturn($code == 0);

        return $cliResult;
    }

    /**
     * Create Target mock.
     *
     * @param  string $file
     * @param  string $fileCompressed
     * @return \phpbu\App\Backup\Target
     */
    protected function getTargetMock($file = '', $fileCompressed = '')
    {
        $compress = !empty($fileCompressed);
        $pathName = $compress ? $fileCompressed : $file;
        $target   = $this->getMockBuilder('\\phpbu\\App\\Backup\\Target')
                         ->disableOriginalConstructor()
                         ->getMock();
        $target->method('getPathnamePlain')->willReturn($file);
        $target->method('getPathname')->willReturn($pathName);
        $target->method('getPath')->willReturn(dirname($pathName));
        $target->method('fileExists')->willReturn(true);
        $target->method('shouldBeCompressed')->willReturn($compress);

        return $target;
    }

    /**
     * Create Compressor Mock.
     *
     * @param  string $cmd
     * @param  string $suffix
     * @return \phpbu\App\Backup\Compressor
     */
    protected function getCompressorMock($cmd, $suffix)
    {
        $compressor = $this->getMockBuilder('\\phpbu\\App\\Backup\\Compressor')
                           ->disableOriginalConstructor()
                           ->getMock();
        $compressor->method('getCommand')->willReturn($cmd);
        $compressor->method('getSuffix')->willReturn($suffix);

        return $compressor;
    }
}
