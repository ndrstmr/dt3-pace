# ADR 0001: Location of the Micro-Frontend Development Environment

* **Status:** Accepted
* **Date:** 2025-06-29
* **Deciders:** Project Architect, AI Assistant Jules

## Context and Problem Statement

For the development of the interactive frontend components of the `DT3-PACE` extension, a hybrid Micro-Frontend (MFE) approach using Web Components has been chosen. The key architectural question is where the source code for this TypeScript-based application should be located, versioned, and developed.

Two primary options were evaluated:

* **Option A: In the TYPO3 Project Root.** The MFE would reside in a separate directory at the same level as the `packages` directory. This provides high autonomy for the frontend team but breaks the encapsulation of the TYPO3 extension.
* **Option B: Within the Extension Directory.** The entire MFE development environment (including `package.json`, `vite.config.ts`, etc.) is located within the extension's `Resources/Private/Frontend/` directory.

## Decision

We have decisively chosen **Option B: Within the Extension Directory**.

The entire source code for the Micro-Frontend will be developed and maintained within the `Resources/Private/Frontend/` directory of the `dt3_pace` extension. The build process will compile the final artifacts to the `Resources/Public/` directory.

## Rationale and Consequences

This decision aligns with the fundamental TYPO3 principles of **encapsulation and portability**.

**Positive Consequences:**
* **Full Encapsulation:** The `dt3_pace` extension is a self-contained, complete unit. Everything required to run, maintain, and further develop the extension is located in a single, version-controlled directory.
* **Standard Compliance:** This approach perfectly respects the TYPO3 convention of separating non-web-accessible source code (`Resources/Private`) from publicly accessible, compiled assets (`Resources/Public`).
* **Simplified Deployment & CI/CD:** Build processes are easier to automate as no cross-directory file operations are needed. The extension can be distributed as a single package (e.g., a ZIP file or a Git repository) and is always complete.
* **Clarity:** There is a single source of truth for the entire extension, benefiting future developers and maintainers.

**Negative Consequences / Trade-offs:**
* **Tighter Organizational Coupling:** Purely frontend-focused teams might perceive their code as being "inside" a PHP project. This is considered a minor organizational trade-off that is heavily outweighed by the technical benefits of full encapsulation and portability for a distributable extension.
