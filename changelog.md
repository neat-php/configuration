# Changelog
All notable changes to Neat Configuration components will be documented in this file.

The format is based on [Keep a Changelog](https://keepachangelog.com/en/1.0.0/)
and this project adheres to [Semantic Versioning](https://semver.org/spec/v2.0.0.html).

## [Unreleased]

## [0.2.2] - 2020-06-19
### Changed
- Remove neat/object dependency (use a local Property class for now).

## [0.2.1] - 2019-10-31
### Changed
- Allow neat/object version ^0.10.

## [0.2.0] - 2019-10-30
### Changed
- Policy setting method will no longer have a prefix parameter.
- Environment query results will no longer contain the prefix in each key.

## [0.1.0] - 2019-10-30
### Added
- Environment implementation.
- Policy implementation for mapping property names to environment settings.
- Settings trait for automatic Settings initialization.
