# ElisDN.ru

Source code of [elisdn.ru](https://elisdn.ru)

## Set Up

Install Docker. Clone:

```
git clone https://github.com/elisdnru/site.git
cd site
```

Run in Linux, MacOS or Windows WSL terminal:

```
make init
```

Open `http://localhost` in your browser.

In the end stop the project:

```
make down
```

## Testing

Run development linters, analysers and tests:

```
make check
```

Try to build production images locally:

```
make try-build
```

Or try to build and test production images in testing environment:

```
make try-testing
```

If it has failed stop testing environment manually:

```
make try-testing-down-clear
```
