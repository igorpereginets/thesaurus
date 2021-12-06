<!-- PROJECT SHIELDS -->

[![Stargazers][stars-shield]][stars-url]
[![Forks][forks-shield]][forks-url]
[![Issues][issues-shield]][issues-url]
[![LinkedIn][linkedin-shield]][linkedin-url]

<!-- PROJECT LOGO -->
<br />
<div align="center">
  <a href="https://github.com/igorpereginets/thesaurus">
    <img src="resources/images/synonymicon.png" alt="Thesaurus" width="80" height="80">
  </a>

<h3 align="center">Thesaurus</h3>

  <p align="center">
    Search for synonyms of any word easily and quickly!
    <br />
    <a href="https://github.com/igorpereginets/thesaurus"><strong>Explore the docs</strong></a>
    <br />
    <br />
    <a href="https://github.com/igorpereginets/thesaurus/issues">Report Bug</a>
    ·
    <a href="https://github.com/igorpereginets/thesaurus/issues">Request Feature</a>
  </p>
</div>

<!-- TABLE OF CONTENTS -->
<details>
  <summary>Table of Contents</summary>
  <ol>
    <li>
      <a href="#about-the-project">About The Project</a>
      <ul>
        <li><a href="#built-with">Built With</a></li>
      </ul>
    </li>
    <li>
      <a href="#getting-started">Getting Started</a>
      <ul>
        <li><a href="#prerequisites">Prerequisites</a></li>
        <li><a href="#installation">Installation</a></li>
        <li><a href="#tests">Tests</a></li>
      </ul>
    </li>
    <li><a href="#contact">Contact</a></li>
    <li><a href="#acknowledgments">Acknowledgments</a></li>
  </ol>
</details>

<!-- ABOUT THE PROJECT -->

## About The Project

There are a lot of projects implementing synonyms search for a given word. This is a base project, very flexible and can
be extended for any need.


Questions you ask yourself:

* Can I use this word in such a context? Is there a better word to use?
* Oh, I'm using this word so much. May I replace it with any other words?
* How can I explain it to my colleagues? :smile:

Then this project is for you. :+1:

Do not hesitate to suggest any changes forking this repo and creating a pull request or opening an issue.

<p align="right">(<a href="#top">back to top</a>)</p>

### Built With

* [PHP](https://www.php.net/)
* [Laravel](https://laravel.com)
* [Swagger](https://swagger.io/)
* [PHPUnit](https://phpunit.de/)

<p align="right">(<a href="#top">back to top</a>)</p>

<!-- GETTING STARTED -->

## Getting Started
### Prerequisites

Install Docker Engine

* Docker
  ```sh
  sudo apt-get update
  sudo apt-get install docker-ce docker-ce-cli containerd.io
  ```
* Test the installation
  ```sh
  docker --version
  ```
* Docker-compose
  ```sh
  sudo curl -L "https://github.com/docker/compose/releases/download/1.29.2/docker-compose-$(uname -s)-$(uname -m)" -o /usr/local/bin/docker-compose
  sudo chmod +x /usr/local/bin/docker-compose
  ```
* Test the installation
  ```sh
  docker-compose --version
  ```

### Installation

1. Clone the repo
   ```sh
   git clone https://github.com/igorpereginets/thesaurus
   cd ./thesaurus
   ```
2. Copy .env file
   ```sh
   cp .env.example .env
   ```
3. Install all packages
   ```sh
   composer install
   ```
4. Run server via docker-compose
    ```sh
   docker-compose up -d
   ```
5. Run migrations
    ```sh
   docker-compose exec -u sail app php artisan migrate
   ```

### Tests

To run test be sure you have created thesaurus-test schema or change it`s name in .env[DB_DATABASE_TEST].

<p align="right">(<a href="#top">back to top</a>)</p>

<!-- CONTACT -->

## Contact

Igor Pereginets - [@igor_pereginets](https://twitter.com/igor_pereginets) - igorpereginets@gmail.com

Project Link: [https://github.com/igorpereginets/thesaurus](https://github.com/igorpereginets/thesaurus)

<p align="right">(<a href="#top">back to top</a>)</p>

<!-- ACKNOWLEDGMENTS -->

## Acknowledgments

* [Laravel Docs](https://laravel.com/docs/8.x)
* [Swagger Docs](https://swagger.io/docs/)
* [PHPUnit Docs](https://phpunit.readthedocs.io/en/9.5/)
* [Img Shields](https://shields.io)

<p align="right">(<a href="#top">back to top</a>)</p>

[forks-shield]: https://img.shields.io/github/forks/igorpereginets/thesaurus

[forks-url]: https://github.com/igorpereginets/thesaurus/network/members

[stars-shield]: https://img.shields.io/github/stars/igorpereginets/thesaurus

[stars-url]: https://github.com/igorpereginets/thesaurus/stargazers

[issues-shield]: https://img.shields.io/github/issues/igorpereginets/thesaurus

[issues-url]: https://github.com/igorpereginets/thesaurus/issues

[linkedin-shield]: https://img.shields.io/badge/-LinkedIn-black.svg?style=social&logo=linkedin&colorB=555

[linkedin-url]: https://www.linkedin.com/in/igor-pereginets-5147b0127/
