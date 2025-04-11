/* eslint-disable */
import * as Router from 'expo-router';

export * from 'expo-router';

declare module 'expo-router' {
  export namespace ExpoRouter {
    export interface __routes<T extends string | object = string> {
      hrefInputParams: { pathname: Router.RelativePathString, params?: Router.UnknownInputParams } | { pathname: Router.ExternalPathString, params?: Router.UnknownInputParams } | { pathname: `/create`; params?: Router.UnknownInputParams; } | { pathname: `/delete`; params?: Router.UnknownInputParams; } | { pathname: `/list`; params?: Router.UnknownInputParams; } | { pathname: `/update`; params?: Router.UnknownInputParams; } | { pathname: `/_sitemap`; params?: Router.UnknownInputParams; };
      hrefOutputParams: { pathname: Router.RelativePathString, params?: Router.UnknownOutputParams } | { pathname: Router.ExternalPathString, params?: Router.UnknownOutputParams } | { pathname: `/create`; params?: Router.UnknownOutputParams; } | { pathname: `/delete`; params?: Router.UnknownOutputParams; } | { pathname: `/list`; params?: Router.UnknownOutputParams; } | { pathname: `/update`; params?: Router.UnknownOutputParams; } | { pathname: `/_sitemap`; params?: Router.UnknownOutputParams; };
      href: Router.RelativePathString | Router.ExternalPathString | `/create${`?${string}` | `#${string}` | ''}` | `/delete${`?${string}` | `#${string}` | ''}` | `/list${`?${string}` | `#${string}` | ''}` | `/update${`?${string}` | `#${string}` | ''}` | `/_sitemap${`?${string}` | `#${string}` | ''}` | { pathname: Router.RelativePathString, params?: Router.UnknownInputParams } | { pathname: Router.ExternalPathString, params?: Router.UnknownInputParams } | { pathname: `/create`; params?: Router.UnknownInputParams; } | { pathname: `/delete`; params?: Router.UnknownInputParams; } | { pathname: `/list`; params?: Router.UnknownInputParams; } | { pathname: `/update`; params?: Router.UnknownInputParams; } | { pathname: `/_sitemap`; params?: Router.UnknownInputParams; };
    }
  }
}
