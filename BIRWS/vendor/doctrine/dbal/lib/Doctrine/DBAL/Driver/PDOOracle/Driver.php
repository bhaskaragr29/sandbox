<?php
/*
 * THIS SOFTWARE IS PROVIDED BY THE COPYRIGHT HOLDERS AND CONTRIBUTORS "AS IS" AND ANY EXPRESS OR IMPLIED WARRANTIES, INCLUDING, BUT NOT LIMITED TO, THE IMPLIED WARRANTIES OF MERCHANTABILITY AND FITNESS FOR A PARTICULAR PURPOSE ARE DISCLAIMED. IN NO EVENT SHALL THE COPYRIGHT OWNER OR CONTRIBUTORS BE LIABLE FOR ANY DIRECT, INDIRECT, INCIDENTAL, SPECIAL, EXEMPLARY, OR CONSEQUENTIAL DAMAGES (INCLUDING, BUT NOT LIMITED TO, PROCUREMENT OF SUBSTITUTE GOODS OR SERVICES; LOSS OF USE, DATA, OR PROFITS; OR BUSINESS INTERRUPTION) HOWEVER CAUSED AND ON ANY THEORY OF LIABILITY, WHETHER IN CONTRACT, STRICT LIABILITY, OR TORT (INCLUDING NEGLIGENCE OR OTHERWISE) ARISING IN ANY WAY OUT OF THE USE OF THIS SOFTWARE, EVEN IF ADVISED OF THE POSSIBILITY OF SUCH DAMAGE. This software consists of voluntary contributions made by many individuals and is licensed under the MIT license. For more information, see <http://www.doctrine-project.org>.
 */
namespace Doctrine\DBAL\Driver\PDOOracle;

use Doctrine\DBAL\Platforms;

/**
 * PDO Oracle driver.
 *
 * WARNING: This driver gives us segfaults in our testsuites on CLOB and other
 * stuff. PDO Oracle is not maintained by Oracle or anyone in the PHP community,
 * which leads us to the recommendation to use the "oci8" driver to connect
 * to Oracle instead.
 */
class Driver implements \Doctrine\DBAL\Driver {
	/**
	 *
	 * @ERROR!!!
	 *
	 */
	public function connect(array $params, $username = null, $password = null, array $driverOptions = array()) {
		return new \Doctrine\DBAL\Driver\PDOConnection ( $this->_constructPdoDsn ( $params ), $username, $password, $driverOptions );
	}
	
	/**
	 * Constructs the Oracle PDO DSN.
	 *
	 * @param array $params        	
	 *
	 * @return string The DSN.
	 */
	private function _constructPdoDsn(array $params) {
		$dsn = 'oci:dbname=';
		
		if (isset ( $params ['host'] ) && $params ['host'] != '') {
			$dsn .= '(DESCRIPTION=(ADDRESS_LIST=(ADDRESS=(PROTOCOL=TCP)' . '(HOST=' . $params ['host'] . ')';
			
			if (isset ( $params ['port'] )) {
				$dsn .= '(PORT=' . $params ['port'] . ')';
			} else {
				$dsn .= '(PORT=1521)';
			}
			
			$database = 'SID=' . $params ['dbname'];
			$pooled = '';
			
			if (isset ( $params ['service'] ) && $params ['service'] == true) {
				$database = 'SERVICE_NAME=' . $params ['dbname'];
			}
			
			if (isset ( $params ['pooled'] ) && $params ['pooled'] == true) {
				$pooled = '(SERVER=POOLED)';
			}
			
			$dsn .= '))(CONNECT_DATA=(' . $database . ')' . $pooled . '))';
		} else {
			$dsn .= $params ['dbname'];
		}
		
		if (isset ( $params ['charset'] )) {
			$dsn .= ';charset=' . $params ['charset'];
		}
		
		return $dsn;
	}
	
	/**
	 *
	 * @ERROR!!!
	 *
	 */
	public function getDatabasePlatform() {
		return new \Doctrine\DBAL\Platforms\OraclePlatform ();
	}
	
	/**
	 *
	 * @ERROR!!!
	 *
	 */
	public function getSchemaManager(\Doctrine\DBAL\Connection $conn) {
		return new \Doctrine\DBAL\Schema\OracleSchemaManager ( $conn );
	}
	
	/**
	 *
	 * @ERROR!!!
	 *
	 */
	public function getName() {
		return 'pdo_oracle';
	}
	
	/**
	 *
	 * @ERROR!!!
	 *
	 */
	public function getDatabase(\Doctrine\DBAL\Connection $conn) {
		$params = $conn->getParams ();
		
		return $params ['user'];
	}
}
