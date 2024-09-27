# Maintainers guide

## Release process

1. **Changelog.** Add a new section to the top of `CHANGES.md` with the output from `composer changelog`.

   Edit your new section by following the [Keep a changelog](https://keepachangelog.com/en/1.0.0/) conventions,
   whereby bullet points are under one of the "Added," "Changed", "Fixed", "Deprecated", or "Removed" labels.

   Review each point and make sure it is phrased in a way that explains the impact on end-users of the library. If the change does not affect the public API or CSS output, remove the bullet point.
2. **Commit.** Stage and commit your changes with the message `Tag vX.Y.Z`, and then push the commit for review.

3. **Tag.** After the above release commit is merged, checkout the main branch and pull down the latest changes. Then create a `vX.Y.Z` tag and push the tag.

   Remember to, after the commit is merged, first checkout the main branch and pull down the latest changes.
   This is to make sure you have the merged version and not the draft commit that you pushed for review.
