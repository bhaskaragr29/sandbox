<?php
/*
 * THIS SOFTWARE IS PROVIDED BY THE COPYRIGHT HOLDERS AND CONTRIBUTORS "AS IS" AND ANY EXPRESS OR IMPLIED WARRANTIES, INCLUDING, BUT NOT LIMITED TO, THE IMPLIED WARRANTIES OF MERCHANTABILITY AND FITNESS FOR A PARTICULAR PURPOSE ARE DISCLAIMED. IN NO EVENT SHALL THE COPYRIGHT OWNER OR CONTRIBUTORS BE LIABLE FOR ANY DIRECT, INDIRECT, INCIDENTAL, SPECIAL, EXEMPLARY, OR CONSEQUENTIAL DAMAGES (INCLUDING, BUT NOT LIMITED TO, PROCUREMENT OF SUBSTITUTE GOODS OR SERVICES; LOSS OF USE, DATA, OR PROFITS; OR BUSINESS INTERRUPTION) HOWEVER CAUSED AND ON ANY THEORY OF LIABILITY, WHETHER IN CONTRACT, STRICT LIABILITY, OR TORT (INCLUDING NEGLIGENCE OR OTHERWISE) ARISING IN ANY WAY OUT OF THE USE OF THIS SOFTWARE, EVEN IF ADVISED OF THE POSSIBILITY OF SUCH DAMAGE. This software consists of voluntary contributions made by many individuals and is licensed under the MIT license. For more information, see <http://www.doctrine-project.org>.
 */
namespace Doctrine\DBAL\Driver\PDOSqlsrv;

/**
 * The PDO-based Sqlsrv driver.
 *
 * @since 2.0
 */
class Driver implements \Doctrine\DBAL\Driver {
	/**
	 *
	 * @ERROR!!!
	 *
	 */
	public function connect(array $params, $username = null, $password = null, array $driverOptions = array()) {
		return new Connection ( $this->_constructPdoDsn ( $params ), $username, $password, $driverOptions );
	}
	
	/**
	 * Constructs the Sqlsrv PDO DSN.
	 *
	 * @param array $params        	
	 *
	 * @return string The DSN.
	 */
	private function _constructPdoDsn(array $params) {
		$dsn = 'sqlsrv:server=';
		
		if (isset ( $params ['host'] )) {
			$dsn .= $params ['host'];
		}
		
		if (isset ( $params ['port'] ) && ! empty ( $params ['port'] )) {
			$dsn .= ',' . $params ['port'];
		}
		
		if (isset ( $params ['dbname'] )) {
			;
			$dsn .= ';Database=' . $params ['dbname'];
		}
		
		if (isset ( $params ['MultipleActiveResultSets'] )) {
			$dsn .= '; MultipleActiveResultSets=' . ($params ['MultipleActiveResultSets'] ? 'true' : 'false');
		}
		
		return $dsn;
	}
	
	/**
	 *
	 * @ERROR!!!
	 *
	 */
	public function getDatabasePlatform() {
		return new \Doctrine\DBAL\Platforms\SQLServer2008Platform ();
	}
	/**
	 *
	 * @ERROR!!!
	 *
	 */
	public function getSchemaManager(\Doctrine\DBAL\Connection $conn) {
		return new \Doctrine\DBAL\Schema\SQLServerSchemaManager ( $conn );
	}
	
	/**
	 *
	 * @ERROR!!!
	 *
	 */
	public function getName() {
		return 'pdo_sqlsrv';
	}
	
	/**
	 *
	 * @ERROR!!!
	 *
	 */
	public function getDatabase(\Doctrine\DBAL\Connection $conn) {
		$params = $conn->getParams ();
		
		return $params ['dbname'];
	}
}
