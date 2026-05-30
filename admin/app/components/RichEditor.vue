<template>
  <div class="rich-editor-wrapper">
    <div ref="editorEl" class="rich-editor" />
  </div>
</template>

<script setup lang="ts">
// Quill is loaded only on client — no SSR issues
const props = defineProps<{
  modelValue: string
  placeholder?: string
}>()

const emit = defineEmits<{
  (e: 'update:modelValue', value: string): void
}>()

const editorEl = ref<HTMLElement | null>(null)
let quill: any = null

onMounted(async () => {
  const { default: Quill } = await import('quill')

  quill = new Quill(editorEl.value!, {
    theme: 'snow',
    placeholder: props.placeholder ?? 'Введите текст...',
    modules: {
      toolbar: [
        [{ header: [1, 2, 3, false] }],
        ['bold', 'italic', 'underline', 'strike'],
        [{ list: 'ordered' }, { list: 'bullet' }],
        [{ indent: '-1' }, { indent: '+1' }],
        ['blockquote', 'code-block'],
        ['link'],
        [{ align: [] }],
        ['clean'],
      ],
    },
  })

  // Set initial value
  if (props.modelValue) {
    quill.clipboard.dangerouslyPasteHTML(props.modelValue)
  }

  // Emit changes
  quill.on('text-change', () => {
    const html = quill.getSemanticHTML()
    // Emit empty string instead of bare <p></p>
    emit('update:modelValue', quill.getText().trim() ? html : '')
  })
})

// Sync from outside (e.g. switching language tabs resets the field)
watch(() => props.modelValue, (val) => {
  if (!quill) return
  const current = quill.getText().trim() ? quill.getSemanticHTML() : ''
  if (val !== current) {
    quill.clipboard.dangerouslyPasteHTML(val ?? '')
  }
})

onUnmounted(() => {
  quill = null
})
</script>

<style>
/* Import Quill snow theme — global because Quill injects its own DOM */
@import 'quill/dist/quill.snow.css';

.rich-editor-wrapper {
  border: 1px solid rgb(229 231 235);
  border-radius: 0.75rem;
  overflow: hidden;
  background: white;
}

.dark .rich-editor-wrapper {
  border-color: rgb(55 65 81);
  background: rgb(17 24 39);
}

/* Toolbar */
.rich-editor-wrapper .ql-toolbar {
  border: none;
  border-bottom: 1px solid rgb(229 231 235);
  background: rgb(249 250 251);
  padding: 8px 12px;
  flex-wrap: wrap;
}

.dark .rich-editor-wrapper .ql-toolbar {
  border-bottom-color: rgb(55 65 81);
  background: rgb(31 41 55);
}

.dark .rich-editor-wrapper .ql-toolbar .ql-stroke {
  stroke: rgb(156 163 175);
}

.dark .rich-editor-wrapper .ql-toolbar .ql-fill {
  fill: rgb(156 163 175);
}

.dark .rich-editor-wrapper .ql-toolbar .ql-picker-label {
  color: rgb(156 163 175);
}

.dark .rich-editor-wrapper .ql-toolbar button:hover .ql-stroke,
.dark .rich-editor-wrapper .ql-toolbar .ql-active .ql-stroke {
  stroke: white;
}

.dark .rich-editor-wrapper .ql-toolbar button:hover .ql-fill,
.dark .rich-editor-wrapper .ql-toolbar .ql-active .ql-fill {
  fill: white;
}

/* Editor area */
.rich-editor-wrapper .ql-container {
  border: none;
  font-family: 'Manrope', system-ui, sans-serif;
  font-size: 0.9rem;
}

.rich-editor-wrapper .ql-editor {
  min-height: 280px;
  max-height: 500px;
  overflow-y: auto;
  padding: 16px;
  color: rgb(17 24 39);
  line-height: 1.7;
}

.dark .rich-editor-wrapper .ql-editor {
  color: rgb(229 231 235);
}

.rich-editor-wrapper .ql-editor.ql-blank::before {
  color: rgb(156 163 175);
  font-style: normal;
}

/* Content styles inside editor */
.rich-editor-wrapper .ql-editor h1 { font-size: 1.75rem; font-weight: 700; margin: 1rem 0 0.5rem; }
.rich-editor-wrapper .ql-editor h2 { font-size: 1.4rem;  font-weight: 700; margin: 1rem 0 0.5rem; }
.rich-editor-wrapper .ql-editor h3 { font-size: 1.15rem; font-weight: 600; margin: 0.75rem 0 0.25rem; }
.rich-editor-wrapper .ql-editor p  { margin-bottom: 0.6rem; }
.rich-editor-wrapper .ql-editor blockquote {
  border-left: 3px solid #D1832C;
  padding-left: 1rem;
  color: rgb(107 114 128);
  font-style: italic;
  margin: 1rem 0;
}
.rich-editor-wrapper .ql-editor pre.ql-syntax {
  background: rgb(31 41 55);
  color: rgb(229 231 235);
  border-radius: 0.5rem;
  padding: 1rem;
  font-size: 0.8rem;
}
</style>
