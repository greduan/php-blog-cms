---
title: Exiting early, cognitive load
layout: blogpost
date: 2018-09-10
redirect: /blog/2018/09/10/exiting-early-cognitive-load
---
Continuing from our [last post about cognitive load][last-post], today we'll
talk about another general practice that will do you good to simplify your
code's logic and reduce its cognitive load.

[last-post]: 2018-09-01-assigning-variables-cognitive-load.html

This post will be about a pattern that I think is referred to as returning early
or something to this effect, but since you could also throw to get out of it
I like "exiting" early.

Here is the scenario for your function:

- Takes one argument, could be an object or an array.
- If it's an object, it can't be empty.
- If it's an array, it can't be empty.
- It can't be anything else.
- If any of the above conditions aren't fulfilled, throw.  (You can do whatever
  you want in your own code, but I'll be throwing.)

There's many ways to go about this logic, of course, but here's how I'd go about
it with the commandment in mind "Exit Early".

```js
// For brevity, we'll use Lodash in our example
const myFunction = theArg => {
  if (!_.isArray(theArg) || !_.isObject(theArg)) {
    throw new Error('theArg must be an object or array.');
  }

  if (_.isArray(theArg) && theArg.length < 1) {
    throw new Error('theArg cannot be an empty array.');
  }

  if (_.isObject(theArg) && Object.keys(theArg).length < 1) {
    throw new Error('theArg cannot be an empty object.');
  }

  if (_.isArray(theArg)) {
    // Array logic here
  } else {
    // Object logic here
  }
};
```

Do you see the pattern?  Perhaps it's more obvious if we show the worst
alternative I can come up with:

```
const myFunction = theArg => {
  if (_.isArray(theArg) || _.isObject(theArg)) {
    if (_.isArray(theArg) && theArg.length > 0) {
      // Array logic here
    } else {
      throw new Error('theArg cannot be an empty array.');
    }
    
    if (_.isObject(theArg) && Object.keys(theArg).length > 0) {
      // Object logic here
    } else {
      throw new Error('theArg cannot be an empty object.');
    }
  } else {
    throw new Error('theArg must be an object or array.');
  }
};
```

Now you be the judge as to which one is easier to read.  For me it's the first
one, without a doubt, even if actually it's more characters I have to type out
as I have to repeat some conditionals.

The basic pattern is to identify which logical branches would prevent your code
from working, and handling them first.  Your if clauses handle the wrong data
first.

This flatens the function structure, makes reading more streamlined,
reorganization of code simpler, and is simply easier to think about, as there
are fewer logical branches.

