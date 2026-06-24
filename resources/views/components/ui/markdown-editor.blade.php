@props([
    'model' => 'body',          // Livewire property name to bind via $wire
    'placeholder' => 'Write your content in markdown…',
    'height' => 520,            // default pane height in px
    'rtl' => false,             // dir="rtl" for Arabic
])

<div
    x-data="mdEditor('{{ $model }}', {{ (int) $height }})"
    x-init="init()"
    class="overflow-hidden rounded-[8px] border border-slate-200 dark:border-slate-700"
>
    {{-- Toolbar --}}
    <div class="flex flex-wrap items-center gap-1 border-b border-slate-200 bg-slate-50 px-2 py-1.5 dark:border-slate-700 dark:bg-slate-800/60">
        <div class="flex flex-wrap items-center gap-0.5">
            <button type="button" @click="wrap('**','**')" title="Bold" class="md-tool"><span class="font-bold">B</span></button>
            <button type="button" @click="wrap('*','*')" title="Italic" class="md-tool italic">I</button>
            <button type="button" @click="wrap('~~','~~')" title="Strikethrough" class="md-tool line-through">S</button>
            <span class="mx-1 h-5 w-px bg-slate-200 dark:bg-slate-700"></span>
            <button type="button" @click="insertLine('# ')" title="Heading 1" class="md-tool">H1</button>
            <button type="button" @click="insertLine('## ')" title="Heading 2" class="md-tool">H2</button>
            <button type="button" @click="insertLine('### ')" title="Heading 3" class="md-tool">H3</button>
            <span class="mx-1 h-5 w-px bg-slate-200 dark:bg-slate-700"></span>
            <button type="button" @click="insertLine('> ')" title="Quote" class="md-tool">
                <svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M3 21c3 0 7-1 7-8V5c0-1.25-.756-2.017-2-2H4c-1.25 0-2 .75-2 1.972V11c0 1.25.75 2 2 2 1 0 1 0 1 1v1c0 1-1 2-2 2s-1 .008-1 1.031V20c0 1 0 1 1 1z"/><path d="M15 21c3 0 7-1 7-8V5c0-1.25-.757-2.017-2-2h-4c-1.25 0-2 .75-2 1.972V11c0 1.25.75 2 2 2h.75c0 2.25.25 4-2.75 4v3c0 1 0 1 1 1z"/></svg>
            </button>
            <button type="button" @click="wrap('`','`')" title="Inline code" class="md-tool font-mono text-xs">&lt;/&gt;</button>
            <button type="button" @click="wrapCodeBlock()" title="Code block" class="md-tool font-mono text-xs">{ }</button>
            <button type="button" @click="insertLine('- ')" title="Bullet list" class="md-tool">•</button>
            <button type="button" @click="insertLine('1. ')" title="Numbered list" class="md-tool">1.</button>
            <button type="button" @click="insertLine('- [ ] ')" title="Checklist" class="md-tool">☑</button>
            <span class="mx-1 h-5 w-px bg-slate-200 dark:bg-slate-700"></span>
            <button type="button" @click="insertLink()" title="Link" class="md-tool">
                <svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M10 13a5 5 0 0 0 7.54.54l3-3a5 5 0 0 0-7.07-7.07l-1.72 1.71"/><path d="M14 11a5 5 0 0 0-7.54-.54l-3 3a5 5 0 0 0 7.07 7.07l1.71-1.71"/></svg>
            </button>
            <button type="button" @click="insertImage()" title="Image" class="md-tool">
                <svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><rect width="18" height="18" x="3" y="3" rx="2"/><circle cx="9" cy="9" r="2"/><path d="m21 15-3.5-3.5a2 2 0 0 0-2.8 0L6 21"/></svg>
            </button>
            <button type="button" @click="insert('\n---\n')" title="Divider" class="md-tool">―</button>
        </div>

        <div class="ml-auto flex items-center gap-2">
            {{-- Height control --}}
            <select x-model.number="height" title="Editor height"
                class="h-7 rounded-md border border-slate-200 bg-white px-1.5 text-xs font-medium text-slate-600 focus:border-primary-500 focus:ring-1 focus:ring-primary-500/40 dark:border-slate-700 dark:bg-slate-800 dark:text-slate-300">
                <option value="320">Short</option>
                <option value="520">Medium</option>
                <option value="720">Tall</option>
                <option value="1000">Extra tall</option>
            </select>

            {{-- Mode toggle --}}
            <div class="flex items-center gap-0.5 rounded-md bg-slate-200/70 p-0.5 dark:bg-slate-700/60">
                <button type="button" @click="mode = 'write'" :class="mode === 'write' ? 'bg-white text-primary-600 shadow-sm dark:bg-slate-900 dark:text-primary-300' : 'text-slate-500'" class="rounded px-2 py-1 text-xs font-semibold transition-colors">Write</button>
                <button type="button" @click="mode = 'split'" :class="mode === 'split' ? 'bg-white text-primary-600 shadow-sm dark:bg-slate-900 dark:text-primary-300' : 'text-slate-500'" class="rounded px-2 py-1 text-xs font-semibold transition-colors">Split</button>
                <button type="button" @click="mode = 'preview'; updatePreview()" :class="mode === 'preview' ? 'bg-white text-primary-600 shadow-sm dark:bg-slate-900 dark:text-primary-300' : 'text-slate-500'" class="rounded px-2 py-1 text-xs font-semibold transition-colors">Preview</button>
            </div>
        </div>
    </div>

    {{-- Editor + Preview (fixed-height panes, internal scroll, synced in split mode) --}}
    <div class="grid" :class="mode === 'split' ? 'lg:grid-cols-2' : 'grid-cols-1'">
        {{-- Textarea --}}
        <div x-show="mode !== 'preview'"
             :style="'height:' + height + 'px'"
             :class="mode === 'split' ? 'border-b lg:border-b-0 lg:border-r border-slate-200 dark:border-slate-700' : ''"
             class="relative bg-white dark:bg-slate-900">
            <textarea
                x-ref="ta"
                x-model="$wire.{{ $model }}"
                @input="updatePreview()"
                @scroll="onEditorScroll()"
                @keydown.tab.prevent="onTab($event)"
                placeholder="{{ $placeholder }}"
                dir="{{ $rtl ? 'rtl' : 'ltr' }}"
                spellcheck="false"
                class="block h-full w-full resize-none border-0 bg-transparent px-4 py-3 font-mono text-sm leading-relaxed text-slate-800 focus:outline-none focus:ring-0 dark:text-slate-100"
            ></textarea>
            <span class="pointer-events-none absolute bottom-2 right-3 rounded bg-white/70 px-1.5 py-0.5 text-[11px] text-slate-400 dark:bg-slate-900/70" x-text="wordCount() + ' words · ' + charCount() + ' chars'"></span>
        </div>

        {{-- Preview --}}
        <div
            x-show="mode !== 'write'"
            x-ref="previewWrap"
            @scroll="onPreviewScroll()"
            :style="'height:' + height + 'px'"
            class="overflow-y-auto bg-slate-50/50 dark:bg-slate-900/40"
        >
            <div class="prose prose-sm max-w-none px-5 py-3 dark:prose-invert" x-html="preview"></div>
        </div>
    </div>

    {{-- Drag-to-resize handle --}}
    <div
        @mousedown.prevent="startResize($event)"
        @touchstart.prevent="startResize($event)"
        class="flex h-2 cursor-row-resize items-center justify-center border-t border-slate-200 bg-slate-50 transition-colors hover:bg-primary-50 dark:border-slate-700 dark:bg-slate-800/60 dark:hover:bg-primary-500/10"
        title="Drag to resize"
    >
        <span class="h-0.5 w-8 rounded-full bg-slate-300 dark:bg-slate-600"></span>
    </div>
</div>

<script>
    function mdEditor(prop, height) {
        return {
            prop: prop,
            mode: 'split',
            height: height || 520,
            preview: '<p class="text-slate-400">Preview will appear here…</p>',
            _syncing: false,
            _resizing: null,
            get ta() { return this.$refs.ta; },

            init() {
                if (window.marked) {
                    window.marked.setOptions({ breaks: true, gfm: true });
                }
                this.$nextTick(() => this.updatePreview());
                window.addEventListener('editor-refresh', () => this.refreshFromWire());
            },

            updatePreview() {
                const val = this.ta ? this.ta.value : '';
                if (! val || ! val.trim()) {
                    this.preview = '<p class="text-slate-400">Nothing to preview yet.</p>';
                    return;
                }
                this.preview = window.marked ? window.marked.parse(val) : '<pre>' + val.replace(/</g, '&lt;') + '</pre>';
                this.$nextTick(() => this.highlight());
            },

            highlight() {
                if (! window.hljs || ! this.$refs.previewWrap) return;
                this.$refs.previewWrap.querySelectorAll('pre code').forEach((el) => {
                    if (! el.dataset.highlighted) {
                        try { window.hljs.highlightElement(el); } catch (e) {}
                        el.dataset.highlighted = '1';
                    }
                });
            },

            // Proportional scroll sync between textarea and preview (split mode only).
            onEditorScroll() { this.syncScroll('editor'); },
            onPreviewScroll() { this.syncScroll('preview'); },
            syncScroll(source) {
                if (this.mode !== 'split' || this._syncing) return;
                const ta = this.ta, pv = this.$refs.previewWrap;
                if (! ta || ! pv) return;
                const taMax = ta.scrollHeight - ta.clientHeight;
                const pvMax = pv.scrollHeight - pv.clientHeight;
                if (taMax <= 0 || pvMax <= 0) return;
                this._syncing = true;
                if (source === 'editor') {
                    pv.scrollTop = (ta.scrollTop / taMax) * pvMax;
                } else {
                    ta.scrollTop = (pv.scrollTop / pvMax) * taMax;
                }
                requestAnimationFrame(() => { this._syncing = false; });
            },

            startResize(e) {
                const clientY = (ev) => (ev.touches ? ev.touches[0].clientY : ev.clientY);
                const startY = clientY(e);
                const startH = this.height;
                const move = (ev) => {
                    this.height = Math.max(220, Math.min(1400, startH + (clientY(ev) - startY)));
                };
                const up = () => {
                    document.removeEventListener('mousemove', move);
                    document.removeEventListener('mouseup', up);
                    document.removeEventListener('touchmove', move);
                    document.removeEventListener('touchend', up);
                };
                document.addEventListener('mousemove', move);
                document.addEventListener('mouseup', up);
                document.addEventListener('touchmove', move, { passive: false });
                document.addEventListener('touchend', up);
            },

            sync() {
                this.updatePreview();
                if (this.ta) this.ta.dispatchEvent(new Event('input', { bubbles: true }));
            },

            refreshFromWire() {
                if (this.$wire && this.prop) {
                    this.ta.value = this.$wire[this.prop] || '';
                }
                this.updatePreview();
            },

            wrap(before, after) {
                const ta = this.ta, start = ta.selectionStart, end = ta.selectionEnd;
                const sel = ta.value.substring(start, end);
                const placeholder = 'text';
                const inner = sel || placeholder;
                ta.setRangeText(before + inner + after, start, end, 'end');
                if (! sel) {
                    ta.selectionStart = start + before.length;
                    ta.selectionEnd = start + before.length + placeholder.length;
                }
                ta.focus();
                this.sync();
            },

            insertLine(prefix) {
                const ta = this.ta, start = ta.selectionStart;
                const lineStart = ta.value.lastIndexOf('\n', start - 1) + 1;
                ta.setRangeText(prefix, lineStart, lineStart, 'end');
                ta.focus();
                this.sync();
            },

            insert(text) {
                const ta = this.ta;
                ta.setRangeText(text, ta.selectionStart, ta.selectionEnd, 'end');
                ta.focus();
                this.sync();
            },

            wrapCodeBlock() {
                const ta = this.ta, start = ta.selectionStart, end = ta.selectionEnd;
                const sel = ta.value.substring(start, end);
                ta.setRangeText('\n```\n' + (sel || 'code') + '\n```\n', start, end, 'end');
                ta.focus();
                this.sync();
            },

            insertLink() {
                const ta = this.ta, start = ta.selectionStart, end = ta.selectionEnd;
                const sel = ta.value.substring(start, end) || 'link text';
                ta.setRangeText('[' + sel + '](https://)', start, end, 'end');
                ta.focus();
                this.sync();
            },

            insertImage() {
                const ta = this.ta, start = ta.selectionStart, end = ta.selectionEnd;
                const sel = ta.value.substring(start, end) || 'alt text';
                ta.setRangeText('![' + sel + '](https://)', start, end, 'end');
                ta.focus();
                this.sync();
            },

            onTab(e) {
                const ta = this.ta, start = ta.selectionStart, end = ta.selectionEnd;
                ta.setRangeText('  ', start, end, 'end');
                this.sync();
            },

            wordCount() {
                const v = this.ta ? this.ta.value.trim() : '';
                return v ? v.split(/\s+/).length : 0;
            },
            charCount() {
                return this.ta ? this.ta.value.length : 0;
            },
        };
    }
</script>
