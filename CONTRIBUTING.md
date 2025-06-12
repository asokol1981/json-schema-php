# Contributing Guide

Thank you for your interest in contributing to **json-schema-php**!

**⚠️ Direct changes to the `main` branch are not allowed.**
All contributions must go through a pull request from a separate branch.

---

## How to Contribute

1. **Clone the repository:**

    ```bash
    git clone https://github.com/asokol1981/json-schema-php.git
    cd json-schema-php
    ```

2. **Create a new branch:**

    ```bash
    git checkout -b <your-branch-name>
    ```

3. **Make your changes**, then commit them:

    ```bash
    git add .
    git commit -m "Describe your changes here"
    ```

4. **Push your branch to GitHub:**

    ```bash
    git push
    ```

    Note: if it's your first push for this branch, use:

    ```bash
    git push --set-upstream origin <your-branch-name>
    ```

5. **Open a pull request** from your branch on GitHub:
   [https://github.com/asokol1981/json-schema-php](https://github.com/asokol1981/json-schema-php)

---

## Before You Submit

Please ensure the following:

- ✅ All tests pass:

    ```bash
    make test
    ```

- ✅ Code coverage remains at 100%:

    ```bash
    make coverage
    ```

- ✅ Codecov config is valid (optional):

    ```bash
    make codecov-validate
    ```

---

## Questions?

If you're unsure about anything, feel free to open an [issue](https://github.com/asokol1981/json-schema-php/issues) or ask in your pull request.

Thanks for helping improve the project! 🙌
