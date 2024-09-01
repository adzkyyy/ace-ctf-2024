import { randomUUID } from 'crypto';
import DOMPurify from 'isomorphic-dompurify';
import { MDXRemote } from 'next-mdx-remote/rsc';
import { join, normalize } from 'path';

interface RemoteMdxParams {
  path: string[];
}

const BASE_URL = 'https://raw.githubusercontent.com/TCP1P/TCP1P_CTF_writeup/main/';

async function fetchMarkdown(url: string): Promise<string> {
  try {
    const res = await fetch(url, {
      method: 'GET',
      headers: {
        'Content-Type': 'text/plain',
      },
    });

    if (!res.ok) {
      throw new Error(`Failed to fetch data: ${res.status} ${res.statusText}`);
    }

    const markdown = await res.text();
    return markdown;
  } catch (error) {
    console.error(`Error fetching and sanitizing Markdown: ${error}`);
    throw new Error('Failed to fetch and sanitize Markdown content');
  }
}

export default async function RemoteMdxPage({ params }: { params: RemoteMdxParams }) {
  const path = join(...params.path);
  const normalizedPath = normalize(decodeURIComponent(path));

  if (!normalizedPath.endsWith('.md') || normalizedPath.includes('..')) {
    return <></>;
  }

  const url = `${BASE_URL}${normalizedPath}`;

  try {
    const sanitizedMarkdown = await fetchMarkdown(url);

    let processedMarkdown = sanitizeMarkdown(sanitizedMarkdown);
    return <MDXRemote source={"# TCP1P Writeup\n\n" + processedMarkdown} />;
  } catch (error) {
    console.error(`Error rendering MDX: ${error}`);
    return <></>;
  }
}

function sanitizeMarkdown(markdown: string): string {
  const tagrep = randomUUID();

  const replaceAngleBrackets = (match: string): string => {
    return match.replace("<", tagrep);
  };

  const restoreAngleBrackets = (match: string): string => {
    return match.replace(tagrep, "<");
  };

  const sanitizeHTMLTags = (match: string): string => {
    return DOMPurify.sanitize(match);
  };

  return markdown
    .replaceAll(/(```).*?\1|`.*?`|{[^}]*?}/gs, (match) => {
      return /```.*?```|[^(``|`)]`.*?`/gs.test(match) ? match : match.replace(/{/g, '&lcub;');
    })
    .replaceAll(/(?:(?!```*```|``*``|`*`)[\s\S])+/gs, replaceAngleBrackets)
    .replaceAll(/```.*?(```|$)|``.*?(``|$)|`.*?(`|$)/gs, restoreAngleBrackets)
    .replaceAll(tagrep, "&lt;")
    .replaceAll(/<([\w]+).*?>.*?<\/\1>/gs, sanitizeHTMLTags)
    .replaceAll(/<([\w]+).*?>.*?<\/\1>|<[\w]+.*?>/gs, (match) => {
      if (/<([\w]+).*?>.*?<\/\1>/gsi.test(match)) {
        return match
      } else {
        return match.replace(/<([\w]+.*?)>/gs, "<$1/>")
      }
    });
}
