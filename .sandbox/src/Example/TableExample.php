<?php

namespace Wikimedia\Codex\Sandbox\Example;

use DateInterval;
use DateTime;
use Wikimedia\Codex\Utility\Codex;
use Wikimedia\Codex\Utility\WebRequestCallbacks;

class TableExample {
	/**
	 * @param Codex $codex
	 * @param WebRequestCallbacks $callbacks
	 * @return string
	 */
	public static function create(
		Codex $codex,
		WebRequestCallbacks $callbacks
	): string {
		$sampleData = self::sampleData();

		//phpcs:ignore
		$limit = isset($_GET["limit"]) ? (int) $_GET["limit"] : 5;
		$allowedLimits = [ 5, 10, 25, 50, 100 ];
		if ( !in_array( $limit, $allowedLimits ) ) {
			$limit = 5;
		}
		//phpcs:ignore
		$offset = $_GET["offset"] ?? null;
		//phpcs:ignore
		$sortColumn = $_GET["sort"] ?? "creation_date";

		$cursorColumn = "creation_date";
		//phpcs:ignore
		$sortDirection = isset( $_GET["desc"] ) && $_GET["desc"] === "1" ? "desc" : "asc";

		$currentOffset = self::getCurrentOffset( $offset );
		$offsetFormatted =
			$currentOffset !== null
				? DateTime::createFromFormat(
				"Y-m-d H:i:s",
				$currentOffset
			)->format( "YmdHis" )
				: null;

		$sampleData = self::sortData( $sampleData, $sortColumn, $sortDirection );
		$totalRecords = count( $sampleData );
		$totalPages = ceil( $totalRecords / $limit );

		$paginatedData = self::paginateData(
			$sampleData,
			$currentOffset,
			$limit,
			$sortDirection,
			$cursorColumn
		);
		$offsets = self::calculateOffsets(
			$sampleData,
			$paginatedData,
			$currentOffset,
			$sortDirection,
			$limit,
			$cursorColumn
		);

		$startOrdinal = self::calculateStartOrdinal(
			$sampleData,
			$currentOffset,
			$sortDirection,
			$cursorColumn
		);
		$endOrdinal = min( $startOrdinal + $limit - 1, $totalRecords );

		return self::generateTable(
			$codex,
			$callbacks,
			$paginatedData,
			$offsetFormatted,
			$totalPages,
			$totalRecords,
			$limit,
			$offsets,
			$sortColumn,
			$sortDirection,
			$startOrdinal,
			$endOrdinal
		);
	}

	/**
	 * Return the current offset based on the input.
	 */
	private static function getCurrentOffset( ?string $offset ): ?string {
		if ( $offset !== null ) {
			$offsetDateTime = DateTime::createFromFormat( "YmdHis", $offset );
			if ( $offsetDateTime !== false ) {
				return $offsetDateTime->format( "Y-m-d H:i:s" );
			}
		}

		return null;
	}

	/**
	 * Sort the data by the given column and direction.
	 */
	private static function sortData(
		array $data,
		string $sortColumn,
		string $sortDirection
	): array {
		usort( $data, static function ( $a, $b ) use (
			$sortColumn,
			$sortDirection
		) {
			return $sortDirection === "asc"
				? $a[$sortColumn] <=> $b[$sortColumn]
				: $b[$sortColumn] <=> $a[$sortColumn];
		} );

		return $data;
	}

	/**
	 * Paginate the data based on the current offset.
	 */
	private static function paginateData(
		array $data,
		?string $currentOffset,
		int $limit,
		string $sortDirection,
		string $cursorColumn
	): array {
		if ( $currentOffset !== null ) {
			$filteredData = array_filter( $data, static function ( $item ) use (
				$currentOffset,
				$sortDirection,
				$cursorColumn
			) {
				return $sortDirection === "asc"
					? $item[$cursorColumn] > $currentOffset
					: $item[$cursorColumn] < $currentOffset;
			} );

			return array_slice( array_values( $filteredData ), 0, $limit );
		}

		return array_slice( $data, 0, $limit );
	}

	/**
	 * Calculate offsets for pagination.
	 */
	private static function calculateOffsets(
		array $sampleData,
		array $paginatedData,
		?string $currentOffset,
		string $sortDirection,
		int $limit,
		string $cursorColumn
	): array {
		$prevOffset = self::calculatePrevOffset(
			$sampleData,
			$currentOffset,
			$sortDirection,
			$limit,
			$cursorColumn
		);

		$nextOffset = null;
		if ( count( $paginatedData ) === $limit ) {
			$lastItem = end( $paginatedData );
			if ( !empty( $lastItem[$cursorColumn] ) ) {
				$nextOffset = DateTime::createFromFormat(
					"Y-m-d H:i:s",
					$lastItem[$cursorColumn]
				)->format( "YmdHis" );
			}
		}

		return [
			"firstOffset" => null,
			"prevOffset" => $prevOffset,
			"nextOffset" => $nextOffset,
			"lastOffset" =>
				count( $sampleData ) > $limit
					? DateTime::createFromFormat(
					"Y-m-d H:i:s",
					$sampleData[count( $sampleData ) - $limit - 1][
					$cursorColumn
					] ?? ""
				)->format( "YmdHis" )
					: null,
		];
	}

	/**
	 * Calculate the previous offset for pagination.
	 */
	private static function calculatePrevOffset(
		array $sampleData,
		?string $currentOffset,
		string $sortDirection,
		int $limit,
		string $cursorColumn
	): ?string {
		if ( $currentOffset === null ) {
			return null;
		}

		$prevData = array_filter( $sampleData, static function ( $item ) use (
			$currentOffset,
			$sortDirection,
			$cursorColumn
		) {
			return $sortDirection === "asc"
				? $item[$cursorColumn] < $currentOffset
				: $item[$cursorColumn] > $currentOffset;
		} );

		$prevData = array_slice( array_values( $prevData ), -$limit );

		if ( count( $prevData ) > 0 ) {
			$firstItem = reset( $sampleData );
			$firstItemOffset = DateTime::createFromFormat(
				"Y-m-d H:i:s",
				$firstItem[$cursorColumn]
			)->format( "YmdHis" );
			$prevOffset = DateTime::createFromFormat(
				"Y-m-d H:i:s",
				reset( $prevData )[$cursorColumn]
			)->format( "YmdHis" );

			if ( $prevOffset === $firstItemOffset ) {
				$firstItemDateTime = DateTime::createFromFormat(
					"YmdHis",
					$firstItemOffset
				);
				$interval = new DateInterval( "P1D" );
				$firstItemDateTime->sub( $interval );

				/* TODO: When upgraded to 8.3, use $firstItemDateTime->modify('-1 day') instead of the code above */

				return $firstItemDateTime->format( "YmdHis" );
			}

			return $prevOffset;
		}

		return null;
	}

	private static function calculateStartOrdinal(
		array $data,
		?string $currentOffset,
		string $sortDirection,
		string $cursorColumn
	): int {
		if ( $currentOffset === null ) {
			return 1;
		}
		$ordinal = 1;
		foreach ( $data as $item ) {
			if (
				( $sortDirection === "asc" &&
					$item[$cursorColumn] > $currentOffset ) ||
				( $sortDirection === "desc" &&
					$item[$cursorColumn] < $currentOffset )
			) {
				break;
			}
			$ordinal++;
		}

		return $ordinal;
	}

	/**
	 * Generate the table with the given data and configuration.
	 */
	private static function generateTable(
		Codex $codex,
		WebRequestCallbacks $callbacks,
		array $paginatedData,
		?string $offsetFormatted,
		int $totalPages,
		int $totalRecords,
		int $limit,
		array $offsets,
		string $sortColumn,
		string $sortDirection,
		int $startOrdinal,
		int $endOrdinal
	): string {
		return $codex
			->Table()
			->setCallbacks( $callbacks )
			->setCaption( "Articles" )
			->setHideCaption( false )
			->setHeaderContent( "List of the articles" )
			->setColumns( self::getColumns() )
			->setData( $paginatedData )
			->setPager(
				$codex
					->Pager()
					->setTotalPages( $totalPages )
					->setTotalResults( $totalRecords )
					->setLimit( $limit )
					->setCurrentOffset( $offsetFormatted )
					->setFirstOffset( $offsets["firstOffset"] ?? null )
					->setPrevOffset( $offsets["prevOffset"] ?? null )
					->setNextOffset( $offsets["nextOffset"] ?? null )
					->setLastOffset( $offsets["lastOffset"] ?? null )
					->setOrdinals( $startOrdinal, $endOrdinal )
					->setPaginationSizeOptions( [ 5, 10, 25, 50, 100 ] )
					->setPaginationSizeDefault( 5 )
					->setCallbacks( $callbacks )
					->setPosition( "bottom" )
					->build()
			)
			->setCurrentSortColumn( $sortColumn )
			->setCurrentSortDirection( $sortDirection )
			->setShowVerticalBorders( true )
			->setPaginationPosition( "bottom" )
			->setFooter( "Displaying sample data for demonstration purposes." )
			->setAttributes( [
				"class" => "foo",
				"bar" => "baz",
			] )
			->build()
			->getHtml();
	}

	/**
	 * Get the columns for the table.
	 */
	private static function getColumns(): array {
		return [
			[
				"id" => "title",
				"label" => "Title",
				"sortable" => true,
			],
			[
				"id" => "page_id",
				"label" => "Page ID",
				"sortable" => true,
			],
			[
				"id" => "diameter_km",
				"label" => "Diameter (km)",
				"sortable" => true,
			],
			[
				"id" => "distance_from_sun_million_km",
				"label" => "Distance from Sun (m. km)",
				"sortable" => true,
			],
			[
				"id" => "creation_date",
				"label" => "Creation Date",
				"sortable" => true,
			],
		];
	}

	/**
	 * Get the sample data for the table.
	 */
	public static function sampleData(): array {
		return [
			[
				"title" => "Mercury",
				"page_id" => 1,
				"diameter_km" => 4879,
				"distance_from_sun_million_km" => 57.9,
				"creation_date" => "2024-01-01 12:00:00",
			],
			[
				"title" => "Venus",
				"page_id" => 2,
				"diameter_km" => 12104,
				"distance_from_sun_million_km" => 108.2,
				"creation_date" => "2024-01-05 14:30:00",
			],
			[
				"title" => "Earth",
				"page_id" => 3,
				"diameter_km" => 12742,
				"distance_from_sun_million_km" => 149.6,
				"creation_date" => "2024-01-10 10:00:00",
			],
			[
				"title" => "Mars",
				"page_id" => 4,
				"diameter_km" => 6779,
				"distance_from_sun_million_km" => 227.9,
				"creation_date" => "2024-02-01 16:15:00",
			],
			[
				"title" => "Jupiter",
				"page_id" => 5,
				"diameter_km" => 139820,
				"distance_from_sun_million_km" => 778.5,
				"creation_date" => "2024-02-05 08:45:00",
			],
			[
				"title" => "Saturn",
				"page_id" => 6,
				"diameter_km" => 116460,
				"distance_from_sun_million_km" => 1434,
				"creation_date" => "2024-02-15 19:30:00",
			],
			[
				"title" => "Uranus",
				"page_id" => 7,
				"diameter_km" => 50724,
				"distance_from_sun_million_km" => 2871,
				"creation_date" => "2024-03-01 12:00:00",
			],
			[
				"title" => "Neptune",
				"page_id" => 8,
				"diameter_km" => 49244,
				"distance_from_sun_million_km" => 4495,
				"creation_date" => "2024-03-10 18:00:00",
			],
			[
				"title" => "Pluto",
				"page_id" => 9,
				"diameter_km" => 2376,
				"distance_from_sun_million_km" => 5906,
				"creation_date" => "2024-04-01 10:00:00",
			],
			[
				"title" => "Ceres",
				"page_id" => 10,
				"diameter_km" => 946,
				"distance_from_sun_million_km" => 414,
				"creation_date" => "2024-04-10 13:00:00",
			],
			[
				"title" => "Haumea",
				"page_id" => 11,
				"diameter_km" => 1632,
				"distance_from_sun_million_km" => 6484,
				"creation_date" => "2024-05-01 11:00:00",
			],
			[
				"title" => "Makemake",
				"page_id" => 12,
				"diameter_km" => 1434,
				"distance_from_sun_million_km" => 6795,
				"creation_date" => "2024-05-05 15:00:00",
			],
			[
				"title" => "Eris",
				"page_id" => 13,
				"diameter_km" => 2326,
				"distance_from_sun_million_km" => 10105,
				"creation_date" => "2024-06-01 09:00:00",
			],
			[
				"title" => "Europa",
				"page_id" => 14,
				"diameter_km" => 3122,
				"distance_from_sun_million_km" => 778.5,
				"creation_date" => "2024-06-10 10:30:00",
			],
			[
				"title" => "Ganymede",
				"page_id" => 15,
				"diameter_km" => 5268,
				"distance_from_sun_million_km" => 778.5,
				"creation_date" => "2024-07-01 14:15:00",
			],
			[
				"title" => "Callisto",
				"page_id" => 16,
				"diameter_km" => 4821,
				"distance_from_sun_million_km" => 778.5,
				"creation_date" => "2024-07-15 16:00:00",
			],
			[
				"title" => "Titan",
				"page_id" => 17,
				"diameter_km" => 5150,
				"distance_from_sun_million_km" => 1434,
				"creation_date" => "2024-08-01 09:45:00",
			],
			[
				"title" => "Enceladus",
				"page_id" => 18,
				"diameter_km" => 504,
				"distance_from_sun_million_km" => 1434,
				"creation_date" => "2024-08-15 13:30:00",
			],
			[
				"title" => "Triton",
				"page_id" => 19,
				"diameter_km" => 2707,
				"distance_from_sun_million_km" => 4495,
				"creation_date" => "2024-09-01 11:15:00",
			],
			[
				"title" => "Charon",
				"page_id" => 20,
				"diameter_km" => 1212,
				"distance_from_sun_million_km" => 5906,
				"creation_date" => "2024-09-15 17:00:00",
			],
			[
				"title" => "Oberon",
				"page_id" => 21,
				"diameter_km" => 1523,
				"distance_from_sun_million_km" => 2871,
				"creation_date" => "2024-10-01 14:00:00",
			],
			[
				"title" => "Rhea",
				"page_id" => 22,
				"diameter_km" => 1528,
				"distance_from_sun_million_km" => 1434,
				"creation_date" => "2024-10-05 20:00:00",
			],
			[
				"title" => "Dione",
				"page_id" => 23,
				"diameter_km" => 1122,
				"distance_from_sun_million_km" => 1434,
				"creation_date" => "2024-10-10 13:30:00",
			],
			[
				"title" => "Iapetus",
				"page_id" => 24,
				"diameter_km" => 1469,
				"distance_from_sun_million_km" => 1434,
				"creation_date" => "2024-10-15 15:00:00",
			],
			[
				"title" => "Tethys",
				"page_id" => 25,
				"diameter_km" => 1060,
				"distance_from_sun_million_km" => 1434,
				"creation_date" => "2024-10-20 10:00:00",
			],
			[
				"title" => "Umbriel",
				"page_id" => 26,
				"diameter_km" => 1190,
				"distance_from_sun_million_km" => 2871,
				"creation_date" => "2024-10-25 12:00:00",
			],
			[
				"title" => "Ariel",
				"page_id" => 27,
				"diameter_km" => 1158,
				"distance_from_sun_million_km" => 2871,
				"creation_date" => "2024-11-01 14:30:00",
			],
			[
				"title" => "Miranda",
				"page_id" => 28,
				"diameter_km" => 471,
				"distance_from_sun_million_km" => 2871,
				"creation_date" => "2024-11-05 09:00:00",
			],
			[
				"title" => "Phobos",
				"page_id" => 29,
				"diameter_km" => 22.4,
				"distance_from_sun_million_km" => 227.9,
				"creation_date" => "2024-11-10 16:30:00",
			],
			[
				"title" => "Deimos",
				"page_id" => 30,
				"diameter_km" => 12.4,
				"distance_from_sun_million_km" => 227.9,
				"creation_date" => "2024-11-15 18:00:00",
			],
		];
	}
}
