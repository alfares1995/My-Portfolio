import type { InertiaLinkProps } from '@inertiajs/vue3';
import type { ClassValue } from 'clsx';
import { clsx } from 'clsx';
import { twMerge } from 'tailwind-merge';

export function cn(...inputs: ClassValue[]) {
    return twMerge(clsx(inputs));
}

export function toUrl(href: NonNullable<InertiaLinkProps['href']>): string {
    if (typeof href === 'string') {
        return href;
    }

    if (href instanceof URL) {
        return href.toString();
    }

    if ('url' in href && typeof href.url === 'string') {
        return href.url;
    }

    if ('href' in href && typeof href.href === 'string') {
        return href.href;
    }

    return String(href);
}
